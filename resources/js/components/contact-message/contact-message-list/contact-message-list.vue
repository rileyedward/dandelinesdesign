<script setup lang="ts">
import { ref } from 'vue';
import { Mail, MessageCircle } from 'lucide-vue-next';
import UiTab from '@/components/ui/navigation/tab/ui-tab.vue';
import type { TabItem } from '@/components/ui/navigation/tab/ui-tab';
import type { ContactMessageListProps as Props } from './contact-message-list';
import ContactMessageBanner from '@/components/contact-message/contact-message-banner/contact-message-banner.vue';

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
              <contact-message-banner
                v-for="message in unreadMessages"
                :key="message.id"
                :message="message"
              />
            </div>
          </div>

          <div v-if="activeTab?.value === 'read'" class="space-y-6 mt-6">
            <div v-if="readMessages.length === 0" class="text-center py-8 text-gray-500">
              No read messages
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <contact-message-banner
                v-for="message in readMessages"
                :key="message.id"
                :message="message"
              />
            </div>
          </div>
        </template>
      </UiTab>
    </div>
  </div>
</template>
