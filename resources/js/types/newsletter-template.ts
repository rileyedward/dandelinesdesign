export interface NewsletterTemplate {
    id: number;
    name: string;
    subject: string;
    content: string;
    preview_text?: string;
    status: 'draft' | 'scheduled' | 'sent';
    sent_at?: string;
    scheduled_at?: string;
    recipients_count: number;
    opens_count: number;
    clicks_count: number;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
