import type { NewsletterSubscriber } from '@/types/newsletter-subscriber';

export interface NewsletterSubscriberListProps {
    activeSubscribers: NewsletterSubscriber[];
    inactiveSubscribers: NewsletterSubscriber[];
    unsubscribedSubscribers: NewsletterSubscriber[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}
