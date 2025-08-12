<script setup lang="ts">
import { Mail, Calendar, Building, Phone } from 'lucide-vue-next';
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
  <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300">
    <div class="flex justify-between items-start mb-4">
      <div>
        <h3 class="text-lg font-semibold text-gray-900">{{ message.name }}</h3>
        <p v-if="message.business_name" class="text-sm text-gray-600 flex items-center">
          <Building class="w-3 h-3 mr-1" />
          {{ message.business_name }}
        </p>
      </div>
      <div v-if="showStatus && !message.is_read" class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
        New
      </div>
    </div>

    <div class="mb-4">
      <h4 class="font-medium text-gray-800 mb-2">{{ message.subject }}</h4>
      <p class="text-gray-700">{{ message.message.length > 150 ? message.message.substring(0, 150) + '...' : message.message }}</p>
    </div>

    <div class="grid grid-cols-2 gap-2 text-sm text-gray-500">
      <div v-if="message.email" class="flex items-center">
        <Mail class="w-4 h-4 mr-1" />
        {{ message.email }}
      </div>
      <div v-if="message.phone_number" class="flex items-center">
        <Phone class="w-4 h-4 mr-1" />
        {{ message.phone_number }}
      </div>
      <div class="flex items-center">
        <Calendar class="w-4 h-4 mr-1" />
        {{ formatDate(message.created_at) }}
      </div>
    </div>
  </div>
</template>
