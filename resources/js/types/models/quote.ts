export interface QuoteData {
    name: string;
    business_name: string | null;
    email: string;
    phone: string | null;
    event_date: string;
    event_type: string;
    event_description: string;
    guest_count: number;
    venue_name: string | null;
    venue_address: string | null;
    budget_range: string;
    special_requests: string | null;
    [key: string]: string | number | null | undefined;
}
