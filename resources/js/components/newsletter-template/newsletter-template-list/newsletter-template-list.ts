import type { NewsletterTemplate } from '@/types/newsletter-template';

export interface NewsletterTemplateListProps {
    newsletterTemplates: NewsletterTemplate[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}
