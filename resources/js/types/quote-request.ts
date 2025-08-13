export interface QuoteRequest {
    id: number;
    name: string;
    email: string;
    phone_number?: string;
    service_type: 'floral_design' | 'event_planning' | 'both';
    event_date?: string;
    event_location?: string;
    guest_count?: number;
    budget?: number;
    description: string;
    status: 'pending' | 'contacted' | 'quoted' | 'completed' | 'cancelled';
    notes?: string;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
