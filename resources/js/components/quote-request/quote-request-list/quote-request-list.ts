import type { QuoteRequest } from '@/types/quote-request';

export interface QuoteRequestListProps {
    pendingRequests: QuoteRequest[];
    contactedRequests: QuoteRequest[];
    quotedRequests: QuoteRequest[];
    completedRequests: QuoteRequest[];
    cancelledRequests: QuoteRequest[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}
