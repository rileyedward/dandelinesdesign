<?php

namespace App\Services\USPS;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class USPSConnector extends Connector
{
    use AcceptsJson, AlwaysThrowOnErrors;

    public function resolveBaseUrl(): string
    {
        return config('services.usps.base_url', 'https://api.usps.com');
    }

    protected function defaultHeaders(): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $accessToken = $this->getAccessToken();
        if ($accessToken) {
            $headers['Authorization'] = 'Bearer '.$accessToken;
        }

        return $headers;
    }

    protected function defaultConfig(): array
    {
        return [
            'timeout' => 30,
        ];
    }

    protected function getAccessToken(): string
    {
        $consumerKey = config('services.usps.consumer_key');
        $consumerSecret = config('services.usps.consumer_secret');

        if (! $consumerKey || ! $consumerSecret) {
            return 'MOCK_TOKEN_FOR_LOCAL_DEVELOPMENT';
        }

        // TODO: Implement OAuth2 token request to USPS
        return 'YOUR_USPS_ACCESS_TOKEN_HERE';
    }
}
