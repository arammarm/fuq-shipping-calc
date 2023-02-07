<?php

namespace App\Helpers;

use App\Models\CalculatorShipping;
use App\Models\StampConfig;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class StampHelper {
    private $apiBaseUrl;
    private $signInBaseUrl;

    private $provider;

    static $tokenKey = 'stamps_access_token';
    static $proType = 'stamps_pro_type';
    static $redirTo = 'stamp_redirect_to';

    public function __construct() {
        $this->initiate();
    }

    private function initiate() {
        $this->signInBaseUrl = env( 'STAMP_STAGE' ) == true ? 'https://signin.testing.stampsendicia.com' : 'https://signin.stampsendicia.com';
        $this->apiBaseUrl    = env( 'STAMP_STAGE' ) == true ? 'https://api.testing.stampsendicia.com' : 'https://api.stampsendicia.com';
        $authUrl             = $this->signInBaseUrl . '/authorize?scope=offline_access';
        $accessTokenUrl      = $this->signInBaseUrl . '/oauth/token';
        $this->provider      = new \League\OAuth2\Client\Provider\GenericProvider( [
            'clientId'                => env( 'STAMP_CLIENT_ID' ),    // The client ID assigned to you by the provider
            'clientSecret'            => env( 'STAMP_SECRET' ),    // The client password assigned to you by the provider
            'redirectUri'             => env( 'STAMP_REDIRECT_URL' ),
            'urlAuthorize'            => $authUrl,
            'urlAccessToken'          => $accessTokenUrl,
            'urlResourceOwnerDetails' => env( 'RESOURCE_OWNER_URL' ),
            'verify'                  => false
        ] );
    }

    public function getAccountDetails() {
        $url   = $this->apiBaseUrl . '/sera/v1/account';
        $token = self::getToken();

        return $this->sendRequest( 'GET', $token, $url );
    }

    public function getAddressValid( CalculatorShipping $address ) {

        $body[] = [
            'name'           => $address->name,
            'address_line1'  => $address->address_line_1,
            'address_line2'  => $address->address_line_2,
            'address_line3'  => $address->address_line_3,
            'city'           => $address->city,
            'state_province' => $address->state_province,
            'postal_code'    => $address->postal_code,
            'country_code'   => $address->country_code,
            'phone'          => $address->phone,
            'email'          => $address->email,
        ];


        $addressUrl = $this->apiBaseUrl . '/sera/v1/addresses/validate';
        $token      = StampHelper::getToken();

        return $this->sendRequest( 'POST', $token, $addressUrl, $body );
    }

    public function getShippingRate( $fromAddress, $toAddress ) {
        $body['from_address'] = [
            'name'           => $fromAddress['admin_name'],
            'address_line1'  => $fromAddress['admin_address_line_1'],
            'address_line2'  => $fromAddress['admin_address_line_2'],
            'address_line3'  => $fromAddress['admin_address_line_3'],
            'city'           => $fromAddress['admin_city'],
            'state_province' => $fromAddress['admin_state_province'],
            'postal_code'    => $fromAddress['admin_postal_code'],
            'country_code'   => $fromAddress['admin_country_code'],
            'phone'          => $fromAddress['admin_phone'],
            'email'          => $fromAddress['admin_email'],
        ];
        $body['to_address']   = [
            'name'           => $toAddress['name'],
            'address_line1'  => $toAddress['address_line_1'],
            'address_line2'  => $toAddress['address_line_2'],
            'address_line3'  => $toAddress['address_line_3'],
            'city'           => $toAddress['city'],
            'state_province' => $toAddress['state_province'],
            'postal_code'    => $toAddress['postal_code'],
            'country_code'   => $toAddress['country_code'],
            'phone'          => $toAddress['phone'],
            'email'          => $toAddress['email'],
        ];
        $body['ship_date']    = Carbon::now()->format( 'Y-m-d' );

        $body['package'] = [
            'weight' => $toAddress['weight']
        ];

        $availableCarriersUrl = $this->apiBaseUrl . '/sera/v1/rates';
        $token                = self::getToken();

        return $this->sendRequest( 'POST', $token, $availableCarriersUrl, $body );
    }


    public function createShippingLabel( $fromAddress, $orderDetail, $idKey ) {
        $token = self::getToken();


        $body['from_address']   = [
            'name'           => self::getSLName( $fromAddress['admin_name'] ),
            'address_line1'  => $fromAddress['admin_address_line_1'],
            'address_line2'  => $fromAddress['admin_address_line_2'],
            'address_line3'  => $fromAddress['admin_address_line_3'],
            'city'           => $fromAddress['admin_city'],
            'state_province' => $fromAddress['admin_state_province'],
            'postal_code'    => $fromAddress['admin_postal_code'],
            'country_code'   => $fromAddress['admin_country_code'],
            'phone'          => $fromAddress['admin_phone'],
            'email'          => $fromAddress['admin_email'],
        ];
        $body['to_address']     = [
            'name'           => self::getSLName( $orderDetail['name'] ),
            'address_line1'  => $orderDetail['address_line_1'],
            'address_line2'  => $orderDetail['address_line_2'],
            'address_line3'  => $orderDetail['address_line_3'],
            'city'           => $orderDetail['city'],
            'state_province' => $orderDetail['state_province'],
            'postal_code'    => $orderDetail['postal_code'],
            'country_code'   => $orderDetail['country_code'],
            'phone'          => $orderDetail['phone'],
            'email'          => $orderDetail['email'],
        ];
        $body['return_address'] = [
            'name'           => self::getSLName( $fromAddress['admin_name'] ),
            'address_line1'  => $fromAddress['admin_address_line_1'],
            'address_line2'  => $fromAddress['admin_address_line_2'],
            'address_line3'  => $fromAddress['admin_address_line_3'],
            'city'           => $fromAddress['admin_city'],
            'state_province' => $fromAddress['admin_state_province'],
            'postal_code'    => $fromAddress['admin_postal_code'],
            'country_code'   => $fromAddress['admin_country_code'],
            'phone'          => $fromAddress['admin_phone'],
            'email'          => $fromAddress['admin_email'],
        ];

        $body['service_type'] = StampHelper::getShippingDetailValue( $orderDetail['carrier_detail'], 'service_type' );
        $body['ship_date']    = Carbon::now()->format( 'Y-m-d' );
        $body['package']      = [
            'packaging_type' => StampHelper::getShippingDetailValue( $orderDetail['carrier_detail'], 'packaging_type' ),
            'weight'         => $orderDetail['weight']
        ];

        $body['order_details'] = [
            'order_date'    => Carbon::now()->format( 'Y-m-d' ),
            'order_source'  => 'Web',
            'order_number'  => $orderDetail['id'],
            'items_ordered' => [
                [
                    'item_name'    => 'Packaging fee',
                    'quantity'     => 1,
                    'item_options' => [
                        [
                            'attribute' => 'Price',
                            'value'     => self::priceFormat( $orderDetail['weight'] )
                        ]
                    ]
                ]
            ]
        ];

        $body['is_test_label'] = true; // TODO: only for test..

        $url = $this->apiBaseUrl . '/sera/v1/labels';

        return $this->sendRequest( 'POST', $token, $url, $body, $idKey );
    }

    public function getShippingCarriers() {
        $availableCarriersUrl = $this->apiBaseUrl . '/sera/v1/carrier-services';
        $token                = self::getToken();

        return $this->sendRequest( 'GET', $token, $availableCarriersUrl );
    }

    public function getAccessToken( $code ) {
        $body = [
            'grant_type'    => 'authorization_code',
            'client_id'     => env( 'STAMP_CLIENT_ID' ),
            'client_secret' => env( 'STAMP_SECRET' ),
            'code'          => $code,
            'redirect_uri'  => env( 'STAMP_REDIRECT_URL' ),
        ];

        return $this->sendRequest( 'POST', null, $this->signInBaseUrl . '/oauth/token', $body );
    }

    public function getRefreshToken( $refreshToken ) {
        $body = [
            'grant_type'    => 'refresh_token',
            'client_id'     => env( 'STAMP_CLIENT_ID' ),
            'client_secret' => env( 'STAMP_SECRET' ),
            'refresh_token' => $refreshToken
        ];

        return $this->sendRequest( 'POST', $refreshToken, 'https://signin.testing.stampsendicia.com/oauth/token', $body );
    }

    public function sendRequest( $type, $token, $url, $bodyArray = null, $idKey = null ) {
        $headers = [
            'Content-Type: application/json'
        ];
        if ( $token != null ) {
            $headers[] = "Authorization: Bearer " . $token;
        }
        if ( $idKey != null ) {
            $headers[] = 'Idempotency-Key: ' . $idKey;
        }

        $curl = curl_init();
        curl_setopt_array( $curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => $type,
            CURLOPT_POSTFIELDS     => ( $bodyArray != null ) ? json_encode( $bodyArray ) : null,
            CURLOPT_HTTPHEADER     => $headers,
        ) );

        $response = curl_exec( $curl );
        curl_close( $curl );

        return json_decode( $response );
    }


    public function authenticate( $redirectTo = null ) {
        self::removeSessions();
        $stamp            = new StampHelper();
        $authorizationUrl = $stamp->getProvider()->getAuthorizationUrl();
        session( 'stamp_oauth2state', $stamp->getProvider()->getState() );
        self::setRedirTo( $redirectTo );

        return redirect()->to( trim( $authorizationUrl ) );
    }

    public static function getCountries() {
        $file = file_get_contents( public_path( 'country_state.json' ) );
        if ( $file ) {
            $countries = json_decode( $file );

            return array_map( function ( $value ) {
                return [ 'code' => $value->countryCode, 'name' => $value->name ];
            }, $countries );
        }

        return null;
    }

    public function getProvider() {
        return $this->provider;
    }

    public static function getShippingDetailValue( $json, $type ) {
        $ob = json_decode( $json );
        if ( $ob != null ) {
            return $ob->{$type};
        }

        return null;
    }

    public static function getToken() {
        $d = StampConfig::first();
        if ( $d ) {
            if ( Carbon::now()->diffInMinutes( Carbon::parse( $d->expired_at ), false ) < 1 ) {
                $rT = ( new StampHelper )->getRefreshToken( $d->refresh_token );
                if ( isset( $rT->access_token ) ) {
                    StampConfig::updateOrInsert(
                        [ 'id' => 1 ],
                        [
                            'access_token' => $rT->access_token,
                            'expired_at'   => Carbon::now()->addSeconds( $rT->expires_in ),
                            'updated_at'   => Carbon::now()
                        ]
                    );

                    return $rT->access_token;
                }
            }

            return $d->access_token;
        }

        return null;
    }

    public static function generateIdKey() {
        return Uuid::uuid4();
    }

    public static function setRedirTo( $url ) {
        session()->put( StampHelper::$redirTo, $url );
    }

    public static function getRedirTo() {
        return session()->get( StampHelper::$redirTo, null );
    }

    public static function priceFormat( $value, $currency = '$' ) {
        return "$currency" . number_format( (float) $value, 2, '.', '' );
    }

    public static function removeSessions() {
        session()->remove( StampHelper::$redirTo );
        session()->remove( StampHelper::$tokenKey );
        session()->remove( StampHelper::$proType );
    }

    public static function getSLName( $full_name ) {
        try {
            $name_parts = explode( " ", $full_name );
            if ( ! isset( $name_parts[1] ) ) {
                $name_parts[1] = 'Us';
            }
            $first_name_initials = substr( $name_parts[0], 0, 2 );
            $last_name_initials  = substr( $name_parts[1], 0, 2 );

            return $first_name_initials . ' ' . $last_name_initials;
        } catch ( \Exception $exception ) {
            return "Un Us";
        }
    }

    public static function readableString( $string ) {
        return ucwords( str_replace( [ '_', '-' ], ' ', $string ) );
    }

    public static function getShippingLogo( $name ) {
        $path = '';
        switch ( $name ) {
            case 'usps':
                $path = asset( 'shipping_logos/usps.png' );
                break;
            case 'globalpost':
                $path = asset( 'shipping_logos/globalpost.png' );
                break;
            case 'ups':
                $path = asset( 'shipping_logos/ups.png' );
                break;
            case 'fedex':
                $path = asset( 'shipping_logos/fedex.png' );
                break;
            case 'dhl_express':
                $path = asset( 'shipping_logos/dhl.png' );
                break;
            case 'canada_post':
                $path = asset( 'shipping_logos/canada_post.png' );
                break;
        }

        return $path;
    }
}
