<?php

namespace App\Helpers;

class StampHelper
{
    private $authUrl;
    private $accessTokenUrl;

    public function __construct()
    {
        $this->authUrl = env('STAMP_STAGE') == 'false' ?  ' https://signin.testing.stampsendicia.com/authorize' : '  https://signin.stampsendicia.com/authorize';
        $this->accessTokenUrl = env('STAMP_STAGE') == 'false' ?  ' https://signin.testing.stampsendicia.com/oauth/token' : ' https://signin.stampsendicia.com/oauth/token';

        $this->authentication();
    }

    private function authentication()
    {
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => env('STAMP_CLIENT_ID'),    // The client ID assigned to you by the provider
            'clientSecret'            => env('STAMP_SECRET'),    // The client password assigned to you by the provider
            'redirectUri'             => env('STAMP_REDIRECT_URL'),
            'urlAuthorize'            => $this->authUrl,
            'urlAccessToken'          => $this->accessTokenUrl,
            'urlResourceOwnerDetails' => env('RESOURCE_OWNER_URL'),
        ]);
    }

    public function get()
    {
        return ['-(-)-'];
    }
}
