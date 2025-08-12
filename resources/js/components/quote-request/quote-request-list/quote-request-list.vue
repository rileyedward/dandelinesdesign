<script setup lang="ts">
import { ref } from 'vue';
import { MessageSquare, Clock, DollarSign, Phone } from 'lucide-vue-next';
import UiTab from '@/components/ui/navigation/tab/ui-tab.vue';
import type { TabItem } from '@/components/ui/navigation/tab/ui-tab';
import type { QuoteRequestListProps as Props } from './quote-request-list';
import QuoteRequestBanner from '@/components/quote-request/quote-request-banner/quote-request-banner.vue';

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
              <quote-request-banner
                v-for="request in pendingRequests"
                :key="request.id"
                :request="request"
              />
            </div>
          </div>

          <div v-if="activeTab?.value === 'contacted'" class="space-y-6 mt-6">
            <div v-if="contactedRequests.length === 0" class="text-center py-8 text-gray-500">
              No contacted quote requests
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <quote-request-banner
                v-for="request in contactedRequests"
                :key="request.id"
                :request="request"
              />
            </div>
          </div>

          <div v-if="activeTab?.value === 'quoted'" class="space-y-6 mt-6">
            <div v-if="quotedRequests.length === 0" class="text-center py-8 text-gray-500">
              No quoted quote requests
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <quote-request-banner
                v-for="request in quotedRequests"
                :key="request.id"
                :request="request"
              />
            </div>
          </div>

          <div v-if="activeTab?.value === 'completed'" class="space-y-6 mt-6">
            <div v-if="completedRequests.length === 0" class="text-center py-8 text-gray-500">
              No completed quote requests
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <quote-request-banner
                v-for="request in completedRequests"
                :key="request.id"
                :request="request"
              />
            </div>
          </div>

          <div v-if="activeTab?.value === 'cancelled'" class="space-y-6 mt-6">
            <div v-if="cancelledRequests.length === 0" class="text-center py-8 text-gray-500">
              No cancelled quote requests
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <QuoteRequestBanner
                v-for="request in cancelledRequests"
                :key="request.id"
                :request="request"
              />
            </div>
          </div>
        </template>
      </UiTab>
    </div>
  </div>
</template>
