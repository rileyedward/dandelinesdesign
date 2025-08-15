import type { NewsletterTemplate } from '@/types/newsletter-template';

export interface NewsletterTemplateListProps {
    draftTemplates?: NewsletterTemplate[];
    sentTemplates?: NewsletterTemplate[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}
