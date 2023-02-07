<?php

namespace App\Http\Controllers;

use App\Helpers\StampHelper;
use App\Models\Config;
use App\Models\StampConfig;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware( 'auth' );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view( 'home' );
    }

    public function configUserAgreementIndex() {
        $agreement = Config::where( 'key', 'agreement' )->first();

        return view( 'configs.user_agreement_config', compact( 'agreement' ) );
    }

    public function configUserAgreementSave() {
        $content = request()->input( 'agreement' );

        Config::updateOrInsert( [ 'key' => 'agreement' ], [ 'content' => $content, 'type' => 'text' ] );

        return redirect()->back()->with( [ 'status' => 'Agreement is successfully saved' ] );
    }

    public function configStampIndex() {

        $config   = StampConfig::first();
        $expireAt = null;
        if ( $config ) {
            $expireAt = Carbon::now()->diffInMinutes( Carbon::parse( $config->expired_at ), false );
        }

        return view( 'configs.stamp_config', compact( 'config', 'expireAt' ) );
    }

    public function authenticateStamp() {
        $stamp = new StampHelper();

        return $stamp->authenticate( route( 'admin.config.stamp' ) );
    }

    public function configAddressIndex() {
        $address   = Config::getAdminAddress();
        $countries = StampHelper::getCountries();

        return view( 'configs.address_config', compact( 'address', 'countries' ) );
    }

    public function configAddressSave() {

        $this->validate( request(), [
            'name'           => 'required',
            'email'          => 'required|email',
            'phone'          => 'required|numeric|digits_between:10,15',
            'address_line_1' => 'required',
            'city'           => 'required',
            'state_province' => 'required',
            'postal_code'    => 'required',
            'country_code'   => 'required',
        ] );

        foreach ( request()->input() as $key => $input ) {
            Config::updateOrInsert( [ 'key' => 'admin_' . $key ], [ 'content' => $input ] );
        }

        return redirect()->back()->with( [ 'status' => 'Address is successfully saved' ] );
    }


}
