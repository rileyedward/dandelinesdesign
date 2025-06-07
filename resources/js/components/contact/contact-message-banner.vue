<script setup lang="ts">
import { ContactMessageBannerEmits as Emits, ContactMessageBannerProps as Props } from '@/types/components/contact-message-banner';
import { formatDate } from '@/utils/date';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const handleMarkAsRead = () => {
    emit('markAsRead', props.contactMessage.id);
};
</script>

<template>
    <div class="mb-4 rounded-lg border border-gray-200 bg-white p-6 shadow-md">
        <div class="flex justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ contactMessage.subject }}</h3>
                <p class="mt-1 text-sm text-gray-600">
                    From: {{ contactMessage.name }} <span v-if="contactMessage.business_name">({{ contactMessage.business_name }})</span>
                </p>
                <p class="text-sm text-gray-600">
                    Email: <a :href="`mailto:${contactMessage.email}`" class="text-blue-600 hover:underline">{{ contactMessage.email }}</a>
                </p>
                <p v-if="contactMessage.phone" class="text-sm text-gray-600">
                    Phone: <a :href="`tel:${contactMessage.phone}`" class="text-blue-600 hover:underline">{{ contactMessage.phone }}</a>
                </p>
                <p class="mt-2 text-sm text-gray-600">Received: {{ formatDate(contactMessage.created_at) }}</p>
            </div>
            <div v-if="!isRead" class="flex items-start">
                <button
                    @click="handleMarkAsRead"
                    class="rounded-md bg-gray-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-500 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-gray-700">{{ contactMessage.message }}</p>
        </div>
    </div>
</template>
