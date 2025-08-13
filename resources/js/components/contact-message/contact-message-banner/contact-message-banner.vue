<script setup lang="ts">
import { Building, Calendar, Mail, Phone } from 'lucide-vue-next';
import type { ContactMessageBannerProps as Props } from './contact-message-banner';

const { message } = withDefaults(defineProps<Props>(), {
    showStatus: true,
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};
</script>

<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-md transition-all duration-300 hover:border-blue-300 hover:shadow-lg">
        <div class="mb-4 flex items-start justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ message.name }}</h3>
                <p v-if="message.business_name" class="flex items-center text-sm text-gray-600">
                    <Building class="mr-1 h-3 w-3" />
                    {{ message.business_name }}
                </p>
            </div>
            <div v-if="showStatus && !message.is_read" class="rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-800">New</div>
        </div>

        <div class="mb-4">
            <h4 class="mb-2 font-medium text-gray-800">{{ message.subject }}</h4>
            <p class="text-gray-700">{{ message.message.length > 150 ? message.message.substring(0, 150) + '...' : message.message }}</p>
        </div>

        <div class="grid grid-cols-2 gap-2 text-sm text-gray-500">
            <div v-if="message.email" class="flex items-center">
                <Mail class="mr-1 h-4 w-4" />
                {{ message.email }}
            </div>
            <div v-if="message.phone_number" class="flex items-center">
                <Phone class="mr-1 h-4 w-4" />
                {{ message.phone_number }}
            </div>
            <div class="flex items-center">
                <Calendar class="mr-1 h-4 w-4" />
                {{ formatDate(message.created_at) }}
            </div>
        </div>
    </div>
</template>
