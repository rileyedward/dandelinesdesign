<script setup lang="ts">
import { QuoteMessageBannerEmits as Emits, QuoteMessageBannerProps as Props } from '@/types/components/quote-message-banner';
import { formatDate } from '@/utils/date';
import { Eye } from 'lucide-vue-next';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const handleShowDetails = () => {
    emit('showDetails', props.quoteMessage);
};
</script>

<template>
    <div class="mb-4 rounded-lg border border-gray-200 bg-white p-6 shadow-md">
        <div class="flex justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ quoteMessage.event_type }}</h3>
                <p class="mt-1 text-sm text-gray-600">
                    From: {{ quoteMessage.name }} <span v-if="quoteMessage.business_name">({{ quoteMessage.business_name }})</span>
                </p>
                <p class="text-sm text-gray-600">
                    Email: <a :href="`mailto:${quoteMessage.email}`" class="text-blue-600 hover:underline">{{ quoteMessage.email }}</a>
                </p>
                <p v-if="quoteMessage.phone" class="text-sm text-gray-600">
                    Phone: <a :href="`tel:${quoteMessage.phone}`" class="text-blue-600 hover:underline">{{ quoteMessage.phone }}</a>
                </p>
                <p class="text-sm text-gray-600">Event Date: {{ formatDate(quoteMessage.event_date, true) }}</p>
                <p class="mt-2 text-sm text-gray-600">Received: {{ formatDate(quoteMessage.created_at) }}</p>
            </div>
            <div class="flex items-start space-x-2">
                <button
                    @click="handleShowDetails"
                    class="rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                    title="View Details"
                >
                    <Eye class="h-5 w-5" />
                </button>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-gray-700">
                {{ quoteMessage.event_description.substring(0, 150) }}{{ quoteMessage.event_description.length > 150 ? '...' : '' }}
            </p>
        </div>
    </div>
</template>
