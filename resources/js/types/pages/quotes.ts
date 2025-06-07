import type { QuoteMessage } from '@/types/models/quote-message';

export interface QuoteAdminPageProps {
    unreadMessages: QuoteMessage[];
    readMessages: QuoteMessage[];
}
