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
        return '?API=TrackV2&XML='.urlencode($this->buildTrackingXML());
    }

    protected function buildTrackingXML(): string
    {
        $userId = config('services.usps.user_id', 'YOUR_USPS_USER_ID');

        return '<TrackRequest USERID="'.$userId.'">'.
               '<TrackID ID="'.$this->trackingNumber.'"></TrackID>'.
               '</TrackRequest>';
    }
}
