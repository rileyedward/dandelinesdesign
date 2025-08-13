import type { QuoteRequest } from '@/types/quote-request';

export interface QuoteRequestFormProps {
    quoteRequest?: QuoteRequest;
    processing?: boolean;
    errors?: Record<string, string>;
}

export interface QuoteRequestFormEmits {
    (event: 'submit', quoteRequest: Partial<QuoteRequest>): void;
    (event: 'cancel'): void;
    (event: 'delete'): void;
}
