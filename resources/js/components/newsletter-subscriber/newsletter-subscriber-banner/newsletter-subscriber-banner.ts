import type { NewsletterSubscriber } from '@/types/newsletter-subscriber';

export interface NewsletterSubscriberBannerProps {
    subscriber: NewsletterSubscriber;
    showStatus?: boolean;
}
