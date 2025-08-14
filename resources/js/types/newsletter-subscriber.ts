export interface NewsletterSubscriber {
    id: number;
    email: string;
    first_name?: string;
    last_name?: string;
    status: 'active' | 'inactive' | 'unsubscribed';
    subscribed_at?: string;
    unsubscribed_at?: string;
    source?: string;
    preferences?: string[];
    tags?: string[];
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}