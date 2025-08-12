import type { Lead } from '@/types/lead';

export interface LeadListProps {
  leads: Lead[];
  loading?: boolean;
  noDataText?: string;
  loadingText?: string;
}