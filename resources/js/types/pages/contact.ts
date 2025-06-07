import type { ContactMessage } from '@/types/models/contact-message';

export interface ContactAdminPageProps {
    unreadMessages: ContactMessage[];
    readMessages: ContactMessage[];
}
