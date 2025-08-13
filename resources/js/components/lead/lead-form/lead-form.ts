import type { Lead } from '@/types/lead';

export interface LeadFormProps {
    lead?: Lead;
    processing?: boolean;
    errors?: Record<string, string>;
}

export interface LeadFormEmits {
    (event: 'submit', lead: Partial<Lead>): void;
    (event: 'cancel'): void;
    (event: 'delete'): void;
}