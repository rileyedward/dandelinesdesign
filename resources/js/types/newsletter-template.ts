export interface NewsletterTemplate {
    id: number;
    name: string;
    subject: string;
    content: string;
    status: 'draft' | 'scheduled' | 'sent';
    sent_at?: string;
    recipients_count: number;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
