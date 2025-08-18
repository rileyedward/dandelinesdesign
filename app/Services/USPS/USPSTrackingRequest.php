<?php

namespace App\Services\USPS;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class USPSTrackingRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $trackingNumber) {}

    public function resolveEndpoint(): string
    {
        return '/tracking/v3/tracking/'.$this->trackingNumber;
    }

    protected function defaultQuery(): array
    {
        return [
            'expand' => 'detail',
        ];
    }
}
