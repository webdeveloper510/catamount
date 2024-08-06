<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PowerBiService
{
    protected $httpClient;
    protected $clientId;
    protected $clientSecret;
    protected $username;
    protected $password;
    protected $aadAuthUrl;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->clientId = env('POWERBI_CLIENT_ID');
        $this->clientSecret = env('POWERBI_CLIENT_SECRET');
        $this->username = env('POWERBI_USERNAME');
        $this->password = env('POWERBI_PASSWORD');
        $this->aadAuthUrl = env('POWERBI_AAD_AUTH_URL');
    }

    public function getAccessToken()
    {
        $response = $this->httpClient->post($this->aadAuthUrl, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'resource' => 'https://analysis.windows.net/powerbi/api',
                'username' => $this->username,
                'password' => $this->password,
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['access_token'];
    }
}
