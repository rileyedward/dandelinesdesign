<script setup lang="ts">
import NotificationCard from '@/components/notification/notification-card/notification-card.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiDrawer from '@/components/ui/layout/drawer/ui-drawer.vue';
import { useNotifications } from '@/composables/useNotifications';
import { Bell } from 'lucide-vue-next';
import type { NotificationDrawerProps as Props } from './notification-drawer';

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const props = defineProps<Props>();
const emit = defineEmits<{
    (e: 'update:show', value: boolean): void;
}>();

const { notifications, unreadCount, isLoading, markAsRead, markAllAsRead } = useNotifications();

const handleNotificationClick = (notification: any) => {
    if (!notification.is_read) {
        markAsRead(notification.id);
    }
    if (notification.action_url) {
        window.location.href = notification.action_url;
    }
};

const handleMarkAsRead = (id: number) => {
    markAsRead(id);
};

const handleMarkAllAsRead = () => {
    markAllAsRead();
};
</script>

<template>
    <ui-drawer
        :show="show"
        title="Notifications"
        description="Stay updated with the latest activity"
        width="450px"
        @update:show="(value) => emit('update:show', value)"
    >
        <div class="space-y-4 h-full flex flex-col">
            <div v-if="notifications.length > 0" class="flex items-center justify-between border-b border-gray-200 pb-3">
                <p class="text-sm font-medium text-gray-900">{{ unreadCount }} unread notification{{ unreadCount !== 1 ? 's' : '' }}</p>
                <UiButton v-if="unreadCount > 0" variant="outline" size="sm" @click="handleMarkAllAsRead"> Mark all read </UiButton>
            </div>

            <div v-if="isLoading" class="flex-grow flex items-center justify-center py-12">
                <div class="text-center">
                    <div class="mx-auto mb-4 h-8 w-8 animate-spin rounded-full border-b-2 border-blue-600"></div>
                    <p class="text-gray-500">Loading notifications...</p>
                </div>
            </div>
            <div v-else-if="notifications.length === 0" class="flex-grow py-12 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                    <Bell class="h-8 w-8 text-gray-400" />
                </div>
                <h3 class="mb-2 text-lg font-medium text-gray-900">No notifications</h3>
                <p class="text-gray-500">You're all caught up! Check back later for updates.</p>
            </div>

            <div v-else class="flex-grow space-y-3 overflow-y-auto pr-2">
                <notification-card
                    v-for="notification in notifications"
                    :key="notification.id"
                    :notification="notification"
                    @click="handleNotificationClick"
                    @mark-as-read="handleMarkAsRead"
                />
            </div>
        </div>
    </ui-drawer>
</template>
