<?php

namespace App\Services;

use App\ValueObjects\ZohoCredentials;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use function Webmozart\Assert\Tests\StaticAnalysis\integer;
use function Webmozart\Assert\Tests\StaticAnalysis\string;

class ZohoCrmApi
{
    private $clientId = "1000.FNBHXF2SNHBAG0BAV2MV65W3VS8VYO";
    private $clientSecret = '26e3a621de9074b6a453bccc05881b8f64a168638e';
    private $redirect = "http://127.0.0.1:8000/api/oauthredirect";
    private $client;

    public function __construct(){
        $this->client = new Client();
    }

    public function Authorization() : string
    {
        $url = 'https://accounts.zoho.eu/oauth/v2/auth?response_type=code&client_id=1000.FNBHXF2SNHBAG0BAV2MV65W3VS8VYO&scope=ZohoCRM.modules.ALL&access_type=offline&redirect_uri=http://127.0.0.1:8000/api/oauthredirect&prompt=consent';
        return $url;
    }

    public function AccessToken($code) : ZohoCredentials
    {
        $url = 'https://accounts.zoho.eu/oauth/v2/token?client_id='.$this->clientId.'&grant_type=authorization_code&client_secret='.$this->clientSecret.'&redirect_uri='.$this->redirect.'&code='.$code;
        $response = $this->client->request('POST', $url, ['verify' => false]);
        $body = (string) $response->getBody();
        $data = json_decode($body);

        $current_timestamp = time();
        $exp_timestamp = $current_timestamp + (integer)$data->expires_in;

        $credentials = new ZohoCredentials($data->access_token, $data->refresh_token, $exp_timestamp);

        Cache::set('credentials', $credentials);

        return $credentials;
    }

    public function UpsertDeal($deal) : bool
    {
        $credentials = Cache::get('credentials');
        $credentials = $this->ValidateAndRefreshCredentials($credentials);

        $url = 'https://www.zohoapis.eu/crm/v3/Deals/upsert';
        $response = $this->client->request('POST', $url,
            [
                'verify' => false,
                'headers' =>[
                    'Authorization' => 'Zoho-oauthtoken '.$credentials->access_token
                ],
                'body' => '
                    {
                      "data": [
                        {
                            "Deal_Name": "'.$deal->name.'",
                            "Stage": "'.$deal->stage.'",
                            "Pipeline": "Standard (Standard)",
                        }
                      ]
                    }
                '
            ]);

        $body = $response->getBody();
        $decoded = json_decode($body);
        $data = $decoded->data;

        if ($data !== null && is_array($data) && isset($data[0])) {
            $firstElement = $data[0];
            if (isset($firstElement->status) && $firstElement->status === 'success') {
                return true;
            }
        }
        return false;
    }

    public function UpsertAccount($account) : bool
    {
        $credentials = Cache::get('credentials');
        $credentials = $this->ValidateAndRefreshCredentials($credentials);

        $url = 'https://www.zohoapis.eu/crm/v3/Accounts/upsert';

        $response = $this->client->request('POST', $url,
            [
                'verify' => false,
                'headers' =>[
                    'Authorization' => 'Zoho-oauthtoken '.$credentials->access_token
                ],
                'body' => '
                    {
                      "data": [
                        {
                            "Account_Name": "'.$account->name.'",
                            "Phone": "'.$account->phone.'",
                            "Website": "'.$account->website.'",
                        }
                      ]
                    }
                '
            ]);

        $body = $response->getBody();
        $decoded = json_decode($body);
        $data = $decoded->data;

        if ($data !== null && is_array($data) && isset($data[0])) {
            $firstElement = $data[0];
            if (isset($firstElement->status) && $firstElement->status === 'success') {
                return true;
            }
        }
        return false;
    }

    private function AccessTokenRefresh() : ZohoCredentials
    {
        $credentials = Cache::get('credentials');
        $url = 'https://accounts.zoho.eu/oauth/v2/token?client_id='.$this->clientId.'&grant_type=refresh_token&client_secret='.$this->clientSecret.'&refresh_token='.$credentials->refresh_token;
        $response = $this->client->request('POST', $url, ['verify' => false]);
        $body = (string) $response->getBody();
        $data = json_decode($body);

        $current_timestamp = time();
        $exp_timestamp = $current_timestamp + (integer)$data->expires_in;

        $credentials = new ZohoCredentials($data->access_token, $credentials->refresh_token, $exp_timestamp);

        Cache::set('credentials', $credentials);

        return $credentials;
    }

    private function ValidateAndRefreshCredentials(ZohoCredentials $credentials) : ZohoCredentials
    {
        $exp_date = date('Y-m-d H:i:s', $credentials->expires);
        $current_date = date('Y-m-d H:i:s');

        if($exp_date < $current_date) {
            return $this->AccessTokenRefresh();
        }

        return $credentials;
    }

    public function test()
    {
        Cache::clear();
    }
}



