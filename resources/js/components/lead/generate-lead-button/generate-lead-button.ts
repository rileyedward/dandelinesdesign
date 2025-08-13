import type { Lead } from '@/types/lead';

export interface GenerateLeadButtonProps {
    name: string;
    email: string;
    phone_number?: string;
    company?: string;
    notes?: string;
    source?: 'website' | 'referral' | 'social_media' | 'advertising' | 'other';
    variant?: 'default' | 'outline' | 'ghost';
    size?: 'sm' | 'md' | 'lg';
    disabled?: boolean;
    loading?: boolean;
}

export interface GenerateLeadButtonEmits {
    (event: 'leadGenerated', lead: Lead): void;
    (event: 'error', errors: Record<string, string>): void;
}
