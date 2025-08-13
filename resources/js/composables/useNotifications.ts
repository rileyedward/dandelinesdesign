import type { Notification } from '@/types/notification';
import axios from 'axios';
import { onMounted, onUnmounted, ref } from 'vue';

export function useNotifications() {
    const notifications = ref<Notification[]>([]);
    const unreadCount = ref(0);
    const isLoading = ref(false);
    let pollInterval: number | null = null;

    const fetchNotifications = async () => {
        try {
            isLoading.value = true;
            const response = await axios.get(route('admin.notifications.unread'));
            notifications.value = response.data;
            unreadCount.value = response.data.filter((n: Notification) => !n.is_read).length;
        } catch (error) {
            console.error('Failed to fetch notifications:', error);
        } finally {
            isLoading.value = false;
        }
    };

    const markAsRead = async (id: number) => {
        try {
            await axios.patch(route('admin.notifications.read', { id }));
            const notification = notifications.value.find((n) => n.id === id);
            if (notification) {
                notification.is_read = true;
                unreadCount.value = Math.max(0, unreadCount.value - 1);
            }
        } catch (error) {
            console.error('Failed to mark notification as read:', error);
        }
    };

    const markAllAsRead = async () => {
        try {
            await axios.patch(route('admin.notifications.read-all'));
            notifications.value.forEach((n) => (n.is_read = true));
            unreadCount.value = 0;
        } catch (error) {
            console.error('Failed to mark all notifications as read:', error);
        }
    };

    const deleteNotification = async (id: number) => {
        try {
            await axios.delete(route('admin.notifications.destroy', { id }));
            const index = notifications.value.findIndex((n) => n.id === id);
            if (index > -1) {
                const notification = notifications.value[index];
                if (!notification.is_read) {
                    unreadCount.value = Math.max(0, unreadCount.value - 1);
                }
                notifications.value.splice(index, 1);
            }
        } catch (error) {
            console.error('Failed to delete notification:', error);
        }
    };

    const startPolling = () => {
        fetchNotifications();
        pollInterval = window.setInterval(fetchNotifications, 30000); // Poll every 30 seconds
    };

    const stopPolling = () => {
        if (pollInterval) {
            clearInterval(pollInterval);
            pollInterval = null;
        }
    };

    onMounted(startPolling);
    onUnmounted(stopPolling);

    return {
        notifications,
        unreadCount,
        isLoading,
        fetchNotifications,
        markAsRead,
        markAllAsRead,
        deleteNotification,
        startPolling,
        stopPolling,
    };
}
