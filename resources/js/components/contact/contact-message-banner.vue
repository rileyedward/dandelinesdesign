<script setup lang="ts">
import { ContactMessageBannerEmits as Emits, ContactMessageBannerProps as Props } from '@/types/components/contact-message-banner';
import { formatDate } from '@/utils/date';
import { Check } from 'lucide-vue-next';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const handleMarkAsRead = () => {
    if (confirm('Are you sure you want to mark this message as read?')) {
        emit('markAsRead', props.contactMessage.id);
    }
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
                    class="flex items-center gap-2 rounded-md bg-green-100 px-3 py-2 text-green-700 hover:bg-green-200 hover:text-green-800 focus:ring-2 focus:ring-green-300 focus:ring-offset-2 focus:outline-none"
                    title="Mark as Read"
                >
                    <Check class="h-5 w-5" />
                </button>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-gray-700">{{ contactMessage.message }}</p>
        </div>
    </div>
</template>
