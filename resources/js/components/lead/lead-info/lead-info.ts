import type { Lead } from '@/types/lead';

export interface LeadInfoProps {
    lead: Lead;
    showEditButton?: boolean;
}

export interface LeadInfoEmits {
    (event: 'updated'): void;
}