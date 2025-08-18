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
        return config('services.usps.base_url', 'https://secure.shippingapis.com/ShippingApi.dll');
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/xml',
            'Accept' => 'application/xml',
        ];
    }

    protected function defaultConfig(): array
    {
        return [
            'timeout' => 30,
        ];
    }
}
