<script setup lang="ts">
import { AlertCircle, AlertTriangle, CheckCircle, Info, Zap } from 'lucide-vue-next';
import type { NotificationCardEmits as Emits, NotificationCardProps as Props } from './notification-card';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const getVariantColors = (type: string) => {
    const variants = {
        primary: {
            bg: 'bg-blue-50 border-blue-200 hover:bg-blue-100',
            icon: 'text-blue-600',
            badge: 'bg-blue-100 text-blue-800',
            iconComponent: Zap,
        },
        success: {
            bg: 'bg-green-50 border-green-200 hover:bg-green-100',
            icon: 'text-green-600',
            badge: 'bg-green-100 text-green-800',
            iconComponent: CheckCircle,
        },
        danger: {
            bg: 'bg-red-50 border-red-200 hover:bg-red-100',
            icon: 'text-red-600',
            badge: 'bg-red-100 text-red-800',
            iconComponent: AlertCircle,
        },
        warning: {
            bg: 'bg-yellow-50 border-yellow-200 hover:bg-yellow-100',
            icon: 'text-yellow-600',
            badge: 'bg-yellow-100 text-yellow-800',
            iconComponent: AlertTriangle,
        },
        info: {
            bg: 'bg-gray-50 border-gray-200 hover:bg-gray-100',
            icon: 'text-gray-600',
            badge: 'bg-gray-100 text-gray-800',
            iconComponent: Info,
        },
    };
    return variants[type as keyof typeof variants] || variants.info;
};

const variant = getVariantColors(props.notification.type);

const formatDate = (dateString: string) => {
    const now = new Date();
    const date = new Date(dateString);
    const diffInMinutes = Math.floor((now.getTime() - date.getTime()) / (1000 * 60));
    if (diffInMinutes < 1) return 'Just now';
    if (diffInMinutes < 60) return `${diffInMinutes}m ago`;

    if (diffInMinutes < 1440) return `${Math.floor(diffInMinutes / 60)}h ago`;
    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const handleClick = () => {
    emit('click', props.notification);
};

const handleMarkAsRead = (event: Event) => {
    event.stopPropagation();
    emit('markAsRead', props.notification.id);
};
</script>

<template>
    <div
        :class="[
            'group relative cursor-pointer rounded-lg border p-4 transition-all duration-200',
            variant.bg,
            notification.is_read ? 'opacity-75' : '',
        ]"
        @click="handleClick"
    >
        <div class="flex items-start gap-3">
            <div :class="['flex-shrink-0 rounded-full p-1', variant.icon]">
                <component :is="variant.iconComponent" class="h-5 w-5" />
            </div>

            <div class="min-w-0 flex-1">
                <div class="mb-2 flex items-center justify-between">
                    <div :class="['inline-flex items-center rounded-full px-2 py-1 text-xs font-medium', variant.badge]">
                        {{ notification.type.charAt(0).toUpperCase() + notification.type.slice(1) }}
                    </div>
                    <span class="text-xs text-gray-500">{{ formatDate(notification.created_at) }}</span>
                </div>

                <h4 class="mb-1 font-semibold text-gray-900">{{ notification.title }}</h4>
                <p class="mb-3 text-sm text-gray-700">{{ notification.message }}</p>

                <div v-if="notification.action_text" class="flex items-center justify-between">
                    <span class="text-xs font-medium text-blue-600"> {{ notification.action_text }} → </span>
                </div>
            </div>

            <div v-if="!notification.is_read" class="flex-shrink-0">
                <button
                    @click="handleMarkAsRead"
                    class="rounded-full p-1 text-gray-400 transition-colors hover:bg-white/50 hover:text-gray-600"
                    aria-label="Mark as read"
                >
                    <CheckCircle class="h-4 w-4" />
                </button>
            </div>
        </div>

        <div v-if="!notification.is_read" class="absolute top-3 left-3 h-2 w-2 rounded-full bg-blue-500"></div>
    </div>
</template>
