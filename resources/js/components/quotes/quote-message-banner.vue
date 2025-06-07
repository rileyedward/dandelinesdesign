<script setup lang="ts">
import { QuoteMessageBannerProps as Props, QuoteMessageBannerEmits as Emits } from '@/types/components/quote-message-banner';
import { formatDate } from '@/utils/date';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const handleMarkAsRead = () => {
    emit('markAsRead', props.quoteMessage.id);
};

const handleShowDetails = () => {
    emit('showDetails', props.quoteMessage);
};
</script>

<template>
    <div class="mb-4 rounded-lg border border-gray-200 bg-white p-6 shadow-md">
        <div class="flex justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ quoteMessage.event_type }}</h3>
                <p class="mt-1 text-sm text-gray-600">From: {{ quoteMessage.name }} <span v-if="quoteMessage.business_name">({{ quoteMessage.business_name }})</span></p>
                <p class="text-sm text-gray-600">Email: <a :href="`mailto:${quoteMessage.email}`" class="text-blue-600 hover:underline">{{ quoteMessage.email }}</a></p>
                <p v-if="quoteMessage.phone" class="text-sm text-gray-600">Phone: <a :href="`tel:${quoteMessage.phone}`" class="text-blue-600 hover:underline">{{ quoteMessage.phone }}</a></p>
                <p class="text-sm text-gray-600">Event Date: {{ formatDate(quoteMessage.event_date, true) }}</p>
                <p class="mt-2 text-sm text-gray-600">Received: {{ formatDate(quoteMessage.created_at) }}</p>
            </div>
            <div class="flex items-start space-x-2">
                <button
                    @click="handleShowDetails"
                    class="rounded-md bg-gray-600 px-3 py-2 text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button
                    v-if="!isRead"
                    @click="handleMarkAsRead"
                    class="rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-gray-700">{{ quoteMessage.event_description.substring(0, 150) }}{{ quoteMessage.event_description.length > 150 ? '...' : '' }}</p>
        </div>
    </div>
</template>
