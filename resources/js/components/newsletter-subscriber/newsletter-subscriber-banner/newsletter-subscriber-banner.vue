<script setup lang="ts">
import { Calendar, Mail, Tag, User } from 'lucide-vue-next';
import type { NewsletterSubscriberBannerProps as Props } from './newsletter-subscriber-banner';

const { subscriber } = withDefaults(defineProps<Props>(), {
    showStatus: true,
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const getStatusColor = (status: string) => {
    switch (status) {
        case 'active':
            return 'bg-green-100 text-green-800';
        case 'inactive':
            return 'bg-yellow-100 text-yellow-800';
        case 'unsubscribed':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const getDisplayName = () => {
    if (subscriber.first_name && subscriber.last_name) {
        return `${subscriber.first_name} ${subscriber.last_name}`;
    } else if (subscriber.first_name) {
        return subscriber.first_name;
    } else if (subscriber.last_name) {
        return subscriber.last_name;
    }
    return subscriber.email;
};
</script>

<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-md transition-all duration-300 hover:border-blue-300 hover:shadow-lg">
        <div class="mb-4 flex items-start justify-between">
            <div class="min-w-0 flex-1">
                <h3 class="truncate text-lg font-semibold text-gray-900">{{ getDisplayName() }}</h3>
                <p class="flex items-center truncate text-sm text-gray-600">
                    <Mail class="mr-1 h-3 w-3 flex-shrink-0" />
                    {{ subscriber.email }}
                </p>
            </div>
            <div v-if="showStatus" :class="getStatusColor(subscriber.status)" class="rounded-full px-2 py-1 text-xs font-medium">
                {{ subscriber.status }}
            </div>
        </div>

        <!-- Source Section - Always present to maintain height -->
        <div class="mb-3 h-5">
            <div v-if="subscriber.source" class="flex items-center text-sm text-gray-600">
                <Tag class="mr-1 h-3 w-3" />
                Source: {{ subscriber.source }}
            </div>
            <div v-else class="flex items-center text-sm text-gray-400">
                <Tag class="mr-1 h-3 w-3" />
                No source specified
            </div>
        </div>

        <!-- Tags Section - Always present to maintain height -->
        <div class="mb-3 h-6">
            <div v-if="subscriber.tags && subscriber.tags.length > 0" class="flex flex-wrap gap-1">
                <span
                    v-for="tag in subscriber.tags.slice(0, 3)"
                    :key="tag"
                    class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700"
                >
                    {{ tag }}
                </span>
                <span v-if="subscriber.tags.length > 3" class="text-xs text-gray-500"> +{{ subscriber.tags.length - 3 }} more </span>
            </div>
            <div v-else class="flex items-center">
                <span class="text-xs text-gray-400">No tags assigned</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 text-sm text-gray-500">
            <div class="flex items-center">
                <User class="mr-1 h-4 w-4" />
                Subscribed
            </div>
            <div class="flex items-center">
                <Calendar class="mr-1 h-4 w-4" />
                {{ formatDate(subscriber.created_at) }}
            </div>
        </div>
    </div>
</template>
