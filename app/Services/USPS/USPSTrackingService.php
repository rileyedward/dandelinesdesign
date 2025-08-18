<?php

namespace App\Services\USPS;

use Illuminate\Support\Facades\Log;
use Saloon\Exceptions\Request\RequestException;

class USPSTrackingService
{
    public function __construct(
        protected USPSConnector $connector
    ) {}

    public function getTrackingInfo(string $trackingNumber): array
    {
        if (app()->environment('local') || ! config('services.usps.enabled', false)) {
            return $this->getMockTrackingData($trackingNumber);
        }

        try {
            $request = new USPSTrackingRequest($trackingNumber);
            $response = $this->connector->send($request);

            return $this->parseUSPSResponse($response->body());
        } catch (RequestException $e) {
            Log::error('USPS API Error', [
                'tracking_number' => $trackingNumber,
                'error' => $e->getMessage(),
            ]);

            return $this->getErrorTrackingData($trackingNumber);
        }
    }

    protected function getMockTrackingData(string $trackingNumber): array
    {
        $baseDate = now()->subDays(3);

        return [
            'tracking_number' => $trackingNumber,
            'status' => 'In Transit',
            'status_code' => 'IN_TRANSIT',
            'expected_delivery' => now()->addDay()->format('Y-m-d'),
            'events' => [
                [
                    'date' => $baseDate->copy()->format('Y-m-d H:i:s'),
                    'time' => $baseDate->copy()->format('H:i:s'),
                    'status' => 'Shipping Label Created',
                    'description' => 'USPS in possession of item',
                    'location' => 'DENVER, CO 80202',
                    'facility' => 'Denver Processing & Distribution Center',
                ],
                [
                    'date' => $baseDate->copy()->addDay()->format('Y-m-d H:i:s'),
                    'time' => $baseDate->copy()->addDay()->format('H:i:s'),
                    'status' => 'In Transit',
                    'description' => 'Your item departed our facility in Denver, CO 80202 on its way to the destination',
                    'location' => 'DENVER, CO 80202',
                    'facility' => 'Denver Processing & Distribution Center',
                ],
                [
                    'date' => $baseDate->copy()->addDays(2)->format('Y-m-d H:i:s'),
                    'time' => $baseDate->copy()->addDays(2)->format('H:i:s'),
                    'status' => 'In Transit',
                    'description' => 'Your item arrived at our facility in Kansas City, MO 64144',
                    'location' => 'KANSAS CITY, MO 64144',
                    'facility' => 'Kansas City Processing & Distribution Center',
                ],
                [
                    'date' => now()->subHours(4)->format('Y-m-d H:i:s'),
                    'time' => now()->subHours(4)->format('H:i:s'),
                    'status' => 'Out for Delivery',
                    'description' => 'Out for delivery, expected delivery by end of day',
                    'location' => 'CHICAGO, IL 60601',
                    'facility' => 'Chicago Post Office',
                ],
            ],
        ];
    }

    protected function getErrorTrackingData(string $trackingNumber): array
    {
        return [
            'tracking_number' => $trackingNumber,
            'status' => 'Error',
            'status_code' => 'ERROR',
            'expected_delivery' => null,
            'events' => [
                [
                    'date' => now()->format('Y-m-d H:i:s'),
                    'time' => now()->format('H:i:s'),
                    'status' => 'Error',
                    'description' => 'Unable to retrieve tracking information. Please verify tracking number or try again later.',
                    'location' => null,
                    'facility' => null,
                ],
            ],
        ];
    }

    protected function parseUSPSResponse(string $xmlResponse): array
    {
        // Parse actual USPS XML response
        // This would contain the logic to parse the USPS XML format
        // and convert it to our standardized format

        try {
            $xml = simplexml_load_string($xmlResponse);

            // TODO: Implement actual USPS XML parsing
            // This is a placeholder for the actual implementation

            return [
                'tracking_number' => (string) $xml->TrackInfo['ID'] ?? '',
                'status' => (string) $xml->TrackInfo->Status ?? 'Unknown',
                'status_code' => $this->mapUSPSStatus((string) $xml->TrackInfo->Status ?? ''),
                'expected_delivery' => (string) $xml->TrackInfo->ExpectedDeliveryDate ?? null,
                'events' => [], // Parse events from XML
            ];
        } catch (\Exception $e) {
            Log::error('USPS XML Parse Error', ['error' => $e->getMessage()]);

            return $this->getErrorTrackingData('');
        }
    }

    protected function mapUSPSStatus(string $uspsStatus): string
    {
        $statusMap = [
            'Delivered' => 'DELIVERED',
            'Out for Delivery' => 'OUT_FOR_DELIVERY',
            'In Transit' => 'IN_TRANSIT',
            'Shipped' => 'SHIPPED',
            'Pre-Shipment' => 'PRE_SHIPMENT',
        ];

        return $statusMap[$uspsStatus] ?? 'UNKNOWN';
    }
}
