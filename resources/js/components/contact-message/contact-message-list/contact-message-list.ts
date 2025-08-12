import type { ContactMessage } from '@/types/contact-message';

export interface ContactMessageListProps {
  readMessages: ContactMessage[];
  unreadMessages: ContactMessage[];
  loading?: boolean;
  noDataText?: string;
  loadingText?: string;
}
