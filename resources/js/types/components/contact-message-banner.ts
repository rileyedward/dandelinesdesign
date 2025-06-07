import { ContactMessage } from '@/types/models/contact-message';

export interface ContactMessageBannerProps {
    contactMessage: ContactMessage;
    isRead: boolean;
}

export interface ContactMessageBannerEmits {
    (e: 'markAsRead', id: number): void;
}
