export interface NewsletterTemplate {
    id: number;
    name: string;
    subject: string;
    content: string;
    preview_text?: string;
    status: 'draft' | 'scheduled' | 'sent';
    scheduled_at?: string;
    sent_at?: string;
    recipients_count: number;
    opens_count: number;
    clicks_count: number;
    tags?: string[];
    metadata?: Record<string, any>;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
