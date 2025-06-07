import { QuoteMessage } from '@/types/models/quote-message';

export interface QuoteMessageBannerProps {
    quoteMessage: QuoteMessage;
    isRead: boolean;
}

export interface QuoteMessageBannerEmits {
    (e: 'markAsRead', id: number): void;
    (e: 'showDetails', quote: QuoteMessage): void;
}
