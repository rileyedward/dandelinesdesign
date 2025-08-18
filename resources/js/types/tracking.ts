export interface TrackingEvent {
    date: string;
    time: string;
    status: string;
    description: string;
    location: string | null;
    facility: string | null;
}

export interface TrackingData {
    tracking_number: string;
    status: string;
    status_code: string;
    expected_delivery: string | null;
    events: TrackingEvent[];
}

export type TrackingStatus = 
    | 'DELIVERED'
    | 'OUT_FOR_DELIVERY'
    | 'IN_TRANSIT'
    | 'SHIPPED'
    | 'PRE_SHIPMENT'
    | 'ERROR'
    | 'UNKNOWN';