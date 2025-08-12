<script setup lang="ts">
import { ref } from 'vue';
import { Calendar, Phone, Mail, MessageSquare, Clock, DollarSign, Users, MapPin } from 'lucide-vue-next';
import UiTab from '@/components/ui/navigation/tab/ui-tab.vue';
import type { TabItem } from '@/components/ui/navigation/tab/ui-tab';
import type { QuoteRequestListProps as Props } from './quote-request-list';

const props = withDefaults(defineProps<Props>(), {
  loading: false,
  noDataText: 'No quote requests found',
  loadingText: 'Loading quote requests...',
});

const selectedTab = ref('pending');

const tabs: TabItem[] = [
  { label: `Pending (${props.pendingRequests.length})`, value: 'pending', icon: Clock },
  { label: `Contacted (${props.contactedRequests.length})`, value: 'contacted', icon: Phone },
  { label: `Quoted (${props.quotedRequests.length})`, value: 'quoted', icon: DollarSign },
  { label: `Completed (${props.completedRequests.length})`, value: 'completed', icon: MessageSquare },
  { label: `Cancelled (${props.cancelledRequests.length})`, value: 'cancelled', icon: MessageSquare },
];

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
</script>

<template>
  <div class="space-y-6">
    <div v-if="loading" class="text-center py-8 text-gray-500">
      {{ loadingText }}
    </div>

    <div v-else>
      <UiTab v-model="selectedTab" :items="tabs" variant="underline">
        <template #default="{ activeTab }">
          <div v-if="activeTab?.value === 'pending'" class="space-y-6 mt-6">
            <div v-if="pendingRequests.length === 0" class="text-center py-8 text-gray-500">
              No pending quote requests
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div
                v-for="request in pendingRequests"
                :key="request.id"
                class="bg-white rounded-lg shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300"
              >
                <div class="flex justify-between items-start mb-4">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ request.name }}</h3>
                    <p class="text-sm text-gray-600">{{ getServiceTypeLabel(request.service_type) }}</p>
                  </div>
                  <div class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                    Pending
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
            </div>
          </div>

          <div v-if="activeTab?.value === 'contacted'" class="space-y-6 mt-6">
            <div v-if="contactedRequests.length === 0" class="text-center py-8 text-gray-500">
              No contacted quote requests
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div
                v-for="request in contactedRequests"
                :key="request.id"
                class="bg-white rounded-lg shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300"
              >
                <div class="flex justify-between items-start mb-4">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ request.name }}</h3>
                    <p class="text-sm text-gray-600">{{ getServiceTypeLabel(request.service_type) }}</p>
                  </div>
                  <div class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                    Contacted
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
            </div>
          </div>

          <div v-if="activeTab?.value === 'quoted'" class="space-y-6 mt-6">
            <div v-if="quotedRequests.length === 0" class="text-center py-8 text-gray-500">
              No quoted quote requests
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div
                v-for="request in quotedRequests"
                :key="request.id"
                class="bg-white rounded-lg shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300"
              >
                <div class="flex justify-between items-start mb-4">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ request.name }}</h3>
                    <p class="text-sm text-gray-600">{{ getServiceTypeLabel(request.service_type) }}</p>
                  </div>
                  <div class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                    Quoted
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
            </div>
          </div>

          <div v-if="activeTab?.value === 'completed'" class="space-y-6 mt-6">
            <div v-if="completedRequests.length === 0" class="text-center py-8 text-gray-500">
              No completed quote requests
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div
                v-for="request in completedRequests"
                :key="request.id"
                class="bg-white rounded-lg shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300"
              >
                <div class="flex justify-between items-start mb-4">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ request.name }}</h3>
                    <p class="text-sm text-gray-600">{{ getServiceTypeLabel(request.service_type) }}</p>
                  </div>
                  <div class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">
                    Completed
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
            </div>
          </div>

          <div v-if="activeTab?.value === 'cancelled'" class="space-y-6 mt-6">
            <div v-if="cancelledRequests.length === 0" class="text-center py-8 text-gray-500">
              No cancelled quote requests
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div
                v-for="request in cancelledRequests"
                :key="request.id"
                class="bg-white rounded-lg shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300"
              >
                <div class="flex justify-between items-start mb-4">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ request.name }}</h3>
                    <p class="text-sm text-gray-600">{{ getServiceTypeLabel(request.service_type) }}</p>
                  </div>
                  <div class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                    Cancelled
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
            </div>
          </div>
        </template>
      </UiTab>
    </div>
  </div>
</template>
