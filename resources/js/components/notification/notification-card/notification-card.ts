import type { Notification } from '@/types/notification';

export interface NotificationCardProps {
    notification: Notification;
}

export interface NotificationCardEmits {
    (event: 'click', notification: Notification): void;
    (event: 'markAsRead', id: number): void;
}
