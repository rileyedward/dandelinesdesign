<script setup lang="ts">
import { Calendar, Phone, Mail, DollarSign, Users, MapPin } from 'lucide-vue-next';
import type { QuoteRequestBannerProps as Props } from './quote-request-banner';

const { request } = withDefaults(defineProps<Props>(), {
  showStatus: true,
});

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};

const formatCurrency = (amount: number) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
  }).format(amount);
};

const getServiceTypeLabel = (type: string) => {
  switch (type) {
    case 'floral_design':
      return 'Floral Design';
    case 'event_planning':
      return 'Event Planning';
    case 'both':
      return 'Floral Design & Event Planning';
    default:
      return type;
  }
};

const getStatusClasses = (status: string) => {
  switch (status) {
    case 'pending':
      return 'bg-yellow-100 text-yellow-800';
    case 'contacted':
      return 'bg-blue-100 text-blue-800';
    case 'quoted':
      return 'bg-green-100 text-green-800';
    case 'completed':
      return 'bg-purple-100 text-purple-800';
    case 'cancelled':
      return 'bg-red-100 text-red-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
};

const getStatusLabel = (status: string) => {
  return status.charAt(0).toUpperCase() + status.slice(1);
};
</script>

<template>
  <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300">
    <div class="flex justify-between items-start mb-4">
      <div>
        <h3 class="text-lg font-semibold text-gray-900">{{ request.name }}</h3>
        <p class="text-sm text-gray-600">{{ getServiceTypeLabel(request.service_type) }}</p>
      </div>
      <div v-if="showStatus" :class="['text-xs px-2 py-1 rounded-full', getStatusClasses(request.status)]">
        {{ getStatusLabel(request.status) }}
      </div>
    </div>

    <div class="mb-4">
      <p class="text-gray-700">{{ request.description.length > 150 ? request.description.substring(0, 150) + '...' : request.description }}</p>
    </div>

    <div class="grid grid-cols-2 gap-2 text-sm text-gray-500">
      <div class="flex items-center">
        <Mail class="w-4 h-4 mr-1" />
        {{ request.email }}
      </div>
      <div v-if="request.phone_number" class="flex items-center">
        <Phone class="w-4 h-4 mr-1" />
        {{ request.phone_number }}
      </div>
      <div v-if="request.event_date" class="flex items-center">
        <Calendar class="w-4 h-4 mr-1" />
        {{ formatDate(request.event_date) }}
      </div>
      <div v-if="request.budget" class="flex items-center">
        <DollarSign class="w-4 h-4 mr-1" />
        {{ formatCurrency(request.budget) }}
      </div>
      <div v-if="request.guest_count" class="flex items-center">
        <Users class="w-4 h-4 mr-1" />
        {{ request.guest_count }} guests
      </div>
      <div v-if="request.event_location" class="flex items-center">
        <MapPin class="w-4 h-4 mr-1" />
        {{ request.event_location }}
      </div>
    </div>
  </div>
</template>
