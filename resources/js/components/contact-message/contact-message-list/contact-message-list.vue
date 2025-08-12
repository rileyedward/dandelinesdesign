<script setup lang="ts">
import { ref } from 'vue';
import { Mail, Calendar, Building, Phone, MessageCircle } from 'lucide-vue-next';
import UiTab from '@/components/ui/navigation/tab/ui-tab.vue';
import type { TabItem } from '@/components/ui/navigation/tab/ui-tab';
import type { ContactMessageListProps as Props } from './contact-message-list';

const props = withDefaults(defineProps<Props>(), {
  loading: false,
  noDataText: 'No messages found',
  loadingText: 'Loading messages...',
});

const selectedTab = ref('unread');

const tabs: TabItem[] = [
  { label: `Unread (${props.unreadMessages.length})`, value: 'unread', icon: Mail },
  { label: `Read (${props.readMessages.length})`, value: 'read', icon: MessageCircle },
];

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
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
          <div v-if="activeTab?.value === 'unread'" class="space-y-6 mt-6">
            <div v-if="unreadMessages.length === 0" class="text-center py-8 text-gray-500">
              No unread messages
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div
                v-for="message in unreadMessages"
                :key="message.id"
                class="bg-white rounded-lg shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300"
              >
                <div class="flex justify-between items-start mb-4">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ message.name }}</h3>
                    <p v-if="message.business_name" class="text-sm text-gray-600 flex items-center">
                      <Building class="w-3 h-3 mr-1" />
                      {{ message.business_name }}
                    </p>
                  </div>
                  <div class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
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
            </div>
          </div>

          <div v-if="activeTab?.value === 'read'" class="space-y-6 mt-6">
            <div v-if="readMessages.length === 0" class="text-center py-8 text-gray-500">
              No read messages
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div
                v-for="message in readMessages"
                :key="message.id"
                class="bg-white rounded-lg shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300"
              >
                <div class="flex justify-between items-start mb-4">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ message.name }}</h3>
                    <p v-if="message.business_name" class="text-sm text-gray-600 flex items-center">
                      <Building class="w-3 h-3 mr-1" />
                      {{ message.business_name }}
                    </p>
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
            </div>
          </div>
        </template>
      </UiTab>
    </div>
  </div>
</template>
