export interface ContactMessage {
    id: number;
    name: string;
    business_name?: string;
    email?: string;
    phone_number?: string;
    subject: string;
    message: string;
    is_read: boolean;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
