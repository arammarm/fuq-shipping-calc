<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Helpers\StampHelper;
use App\Models\CalculatorShipping;
use App\Models\Config;
use App\Models\StampConfig;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\Stripe;

class FrontController extends Controller {
    public function index() {
        StampHelper::removeSessions();
        $agreement = Config::where( 'key', 'agreement' )->first();
        $countries = StampHelper::getCountries();

        return view( 'welcome', compact( 'agreement', 'countries' ) );
    }

    public function shippingFormSubmit() {
        StampHelper::removeSessions();
        $this->validate( request(), [
            'name'           => 'required',
            'email'          => 'required|email',
            'phone'          => 'required|numeric|digits_between:10,15',
            'address_line_1' => 'required',
            'city'           => 'required',
            'state_province' => 'required',
            'postal_code'    => 'required',
            'weight'         => 'required|numeric',
        ] );

        $calc = CalculatorShipping::create( [
            'name'           => request()->input( 'name' ),
            'email'          => request()->input( 'email' ),
            'phone'          => request()->input( 'phone' ),
            'address_line_1' => request()->input( 'address_line_1' ),
            'address_line_2' => request()->input( 'address_line_2' ),
            'address_line_3' => request()->input( 'address_line_3' ),
            'city'           => request()->input( 'city' ),
            'state_province' => request()->input( 'state_province' ),
            'postal_code'    => request()->input( 'postal_code' ),
            'country_code'   => 'us',
            'weight'         => ceil( request()->input( 'weight' ) )
        ] );
        return redirect()->route( 'form.shipping.carrier', [ $calc->id ] )->withInput();
    }

    public function shippingCarrierForm( $id ) {
        $rec              = CalculatorShipping::findOrFail( $id );
        $error            = null;
        $stamp            = new StampHelper();
        $addressResponse  = $stamp->getAddressValid( $rec );
        $validAddress     = null;
        $shippingServices = [];
        if ( isset( $response->message ) ) {
            $error = $response->message;
        } else {
            if ( is_array( $addressResponse ) && isset( $addressResponse[0] ) ) {
                $validAddress = $addressResponse[0]->matched_address ?->formatted_address;
            }
            $rec->update( [ 'verified_address' => json_encode( $addressResponse[0]->matched_address ) ] );
        }
        if ( $error == null ) {
            $fromAddress = Config::getAdminAddress();
            if ( empty( $fromAddress ) ) {
                $error = 'Shipping from address not configured contact administrator';
            } else {
                $rateResponse = $stamp->getShippingRate( $fromAddress, $rec->toArray() );
                if ( isset( $response->message ) ) {
                    $error = $response->message;
                } else {
                    $shippingServices = $rateResponse;
                }
            }
        }

        return view( 'pages.shipping_carriers', compact( 'error', 'rec', 'validAddress', 'shippingServices' ) );
    }

    public function shippingCarrierSubmit() {
        $this->validate( request(), [
            'record_id'        => 'required|numeric',
            'shipping_service' => 'required'
        ], [ 'record_id' => 'Invalid request. Please try again', 'shipping_service.required' => 'You must select a shipping carrier' ] );

        $d            = [];
        $rec          = CalculatorShipping::findOrFail( request()->input( 'record_id' ) );
        $shipping     = request()->input( 'shipping_service' );
        $shippingData = json_decode( $shipping );
        if ( ! $shippingData ) {
            return redirect()->back()->withErrors( [ 'shipping' => 'Shipping carrier  is missing' ] )->withInput();
        }
        $rec->update( [
            'shipping_carrier' => $shippingData ?->carrier,
            'carrier_detail'   => $shipping
        ] );

        $d['paylist'][] = [ 'description' => '', 'name' => 'Packaging Fee', 'value' => $rec->weight ];
        $d['paylist'][] = [
            'description' => StampHelper::readableString( $shippingData->service_type ),
            'name'        => 'Shipping Cost',
            'value'       => $shippingData ?->shipment_cost ?->total_amount
        ];
        $d['total'] = ( floatval( $shippingData ?->shipment_cost ?->total_amount) + floatval( $rec->weight ));
        $d['rec']             = $rec;
        $d['verifiedAddress'] = json_decode( $rec->verified_address ) ?->formatted_address;
        return view( 'pages.summary_checkout', $d );
    }

    public function shippingCheckout() {
        $this->validate( \request(), [ 'id' => 'required|numeric', 'total' => 'required|numeric' ] );
        $rec = CalculatorShipping::findOrFail( request()->input( 'id' ) );
        $rec->update( [ 'done' => false ] );
        $total = \request()->input( 'total' );
        Stripe::setApiKey( env( 'STRIPE_SECRET' ) );
        $weight      = floatval( $rec->weight ) . ' lbs';
        $fullAddress = json_decode( $rec->verified_address ) ?->formatted_address;

        $rec->update( [ 'required_payment' => $total ] );

        $checkout_session = \Stripe\Checkout\Session::create( [
            'payment_method_types' => [ 'card' ],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name'        => 'Packaging & Shipping',
                            'description' => "Package weight: $weight, \n Delivery Address:  \n" . $fullAddress
                        ],
                        'unit_amount'  => intval( $total * 100 ),
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => route( 'form.shipping.stripe.success', [ $rec->id ] ),
            'cancel_url'           => route( 'form.shipping.stripe.cancel', [ $rec->id ] ),
            'customer_email'       => $rec->email
        ] );

        return redirect()->to( $checkout_session->url );
    }

    public function stampAuthenticate() {
        $message  = 'Your login failed please try again!';
        $stamp    = new StampHelper();
        $provider = $stamp->getProvider();
        if ( request()->has( 'code' ) ) {
            if ( request()->has( 'state' ) ) {
                $code  = request()->get( 'code' );
                $state = request()->get( 'state' );
                try {
                    $accessToken = $stamp->getAccessToken( $code );

                    if ( isset( $accessToken->access_token ) ) {
                        $message = null;
                        if ( StampHelper::getRedirTo() != null ) {

                            StampConfig::updateOrInsert(
                                [ 'id' => 1 ],
                                [
                                    'client_id'     => env( 'STAMP_CLIENT_ID' ),
                                    'access_token'  => $accessToken->access_token,
                                    'refresh_token' => $accessToken->refresh_token ?? "",
                                    'expired_at'    => Carbon::now()->addSeconds( $accessToken->expires_in ),
                                    'updated_at'    => Carbon::now()
                                ]
                            );

                            return redirect()->to( StampHelper::getRedirTo() );
                        }
                        echo '<code>' . $accessToken->access_token . '</code>';
                    } else {
                        $message = isset( $accessToken->error_description ) ? $accessToken->error_description : "Cannot get access token";
                    }
                } catch ( \Exception $e ) {
                    $message = ( $e->getMessage() );
                }
            }
        }

        return view( 'pages.invalid_state', compact( 'message' ) );
    }


    public function shippingPaymentSuccess( $id ) {
        $rec = CalculatorShipping::findOrFail( $id );
        if ( $rec->done ) {
            return view( 'pages.message', [ 'title' => 'Checkout', 'message' => "This request already processed", 'type' => 'error' ] );
        }
//        $rec->update( [ 'done' => true ] ); // TODO: should true on.

        $rec->update( [ 'paid' => true ] );
        $fromAddress = Config::getAdminAddress();
        $stamp       = new StampHelper();
        $idKey       = StampHelper::generateIdKey();
        $response    = $stamp->createShippingLabel( $fromAddress, $rec->toArray(), $idKey );
        print_r( ( $response ) );
        die();

        $shippingData   = json_decode( $rec->carrier_detail );
        $d['paylist'][] = [ 'description' => '', 'name' => 'Packaging Fee', 'value' => $rec->weight ];
        $d['paylist'][] = [
            'description' => StampHelper::readableString( $shippingData->service_type ),
            'name'        => 'Shipping Cost',
            'value'       => $shippingData ?->shipment_cost ?->total_amount
        ];

        $d['total'] = ( floatval( $shippingData ?->shipment_cost ?->total_amount) + floatval( $rec->weight ));
        $d['rec']             = $rec;
        $d['verifiedAddress'] = json_decode( $rec->verified_address ) ?->formatted_address;

        $emailTemplate = view( 'includes.shipping_checkout_email', $d );

//
//        $response      = CommonHelper::composeEmail( $rec->email, null, 'Order Confirmed', $emailTemplate );
//
//
//        print_r( $response );

    }

    public function ShippingPaymentCancel( $id ) {
        $rec = CalculatorShipping::findOrFail( $id );
        if ( $rec->done ) {
            return view( 'pages.message', [ 'title' => 'Checkout', 'message' => "This request already processed", 'type' => 'error' ] );
        }
        $rec->update( [ 'done' => true ] );
    }
}
