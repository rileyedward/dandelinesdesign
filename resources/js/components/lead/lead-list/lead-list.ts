import type { Lead } from '@/types/lead';

export interface LeadListProps {
    newLeads: Lead[];
    contactedLeads: Lead[];
    qualifiedLeads: Lead[];
    proposalLeads: Lead[];
    wonLeads: Lead[];
    lostLeads: Lead[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}
