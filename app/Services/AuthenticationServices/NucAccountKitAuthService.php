<?php

namespace App\Services\AuthenticationServices;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Response;

class NucAccountKitAuthService extends ANucAuthService
{
    private $appId;
    private $appSecret;
    private $tokenExchangeUrl;
    private $endPointUrl;
    public $userAccessToken;
    private $refreshInterval;
    /**
     * @var GuzzleHttpClient
     */
    private $client;

    public function __construct()
    {
        $this->appId            = config('accountkit.app_id');
        $this->client           = new GuzzleHttpClient();
        $this->appSecret        = config('accountkit.app_secret');
        $this->endPointUrl      = config('accountkit.end_point');
        $this->tokenExchangeUrl = config('accountkit.tokenExchangeUrl');
    }

    protected function loginAndGetUserData($request)
    {
        if (!config('accountkit.allowUserAccessToken')){
            $auth_code = $request->header('auth-code');
            if (!$auth_code) {
                return Response::json(['error'=>'Missing Authorization Code!'], 401);
            }
            $this->login($auth_code);
        } else {
            $access_token = $request->header('access-token');
            $this->userAccessToken = $access_token;
        }

        return $this->getData();
    }

    private function login($authCode){
        $url = $this->tokenExchangeUrl.'grant_type=authorization_code'.
            '&code='. $authCode.
            "&access_token=AA|$this->appId|$this->appSecret";

        $apiRequest = $this->client->request('GET', $url);
        $body = json_decode($apiRequest->getBody());
        $this->userAccessToken = $body->access_token;
        $this->refreshInterval = $body->token_refresh_interval_sec;
    }

    private function getData()
    {
        $request = $this->client->request('GET', $this->endPointUrl.$this->userAccessToken);
        $data = \GuzzleHttp\json_decode($request->getBody());
        $userId = $data->id;
        $userAccessToken = $this->userAccessToken;
        $refreshInterval = $this->refreshInterval;
        $phone = isset($data->phone) ? $data->phone->number : '';
        $email = isset($data->email) ? $data->email->address : '';
        return compact('phone', 'email', 'userId', 'userAccessToken', 'refreshInterval');
    }

}
