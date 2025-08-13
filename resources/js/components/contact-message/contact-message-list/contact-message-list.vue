<script setup lang="ts">
import ContactMessageBanner from '@/components/contact-message/contact-message-banner/contact-message-banner.vue';
import ContactMessageModal from '@/components/contact-message/contact-message-modal/contact-message-modal.vue';
import type { TabItem } from '@/components/ui/navigation/tab/ui-tab';
import UiTab from '@/components/ui/navigation/tab/ui-tab.vue';
import type { ContactMessage } from '@/types/contact-message';
import { Mail, MessageCircle } from 'lucide-vue-next';
import { ref } from 'vue';
import type { ContactMessageListProps as Props } from './contact-message-list';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No messages found',
    loadingText: 'Loading messages...',
});

const selectedTab = ref('unread');
const showModal = ref(false);
const selectedMessage = ref<ContactMessage | null>(null);

const tabs: TabItem[] = [
    { label: `Unread (${props.unreadMessages.length})`, value: 'unread', icon: Mail },
    { label: `Read (${props.readMessages.length})`, value: 'read', icon: MessageCircle },
];

const handleMessageClick = (message: ContactMessage) => {
    selectedMessage.value = message;
    showModal.value = true;
};

const handleMessageUpdated = () => {
    // Reload the page to refresh the message lists
    window.location.reload();
};
</script>

<template>
    <div class="space-y-6">
        <div v-if="loading" class="py-8 text-center text-gray-500">
            {{ loadingText }}
        </div>

        <div v-else>
            <UiTab v-model="selectedTab" :items="tabs" variant="underline">
                <template #default="{ activeTab }">
                    <div v-if="activeTab?.value === 'unread'" class="mt-6 space-y-6">
                        <div v-if="unreadMessages.length === 0" class="py-8 text-center text-gray-500">No unread messages</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div
                                v-for="message in unreadMessages"
                                :key="message.id"
                                class="cursor-pointer"
                                @click="handleMessageClick(message)"
                            >
                                <contact-message-banner :message="message" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'read'" class="mt-6 space-y-6">
                        <div v-if="readMessages.length === 0" class="py-8 text-center text-gray-500">No read messages</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div
                                v-for="message in readMessages"
                                :key="message.id"
                                class="cursor-pointer"
                                @click="handleMessageClick(message)"
                            >
                                <contact-message-banner :message="message" />
                            </div>
                        </div>
                    </div>
                </template>
            </UiTab>
        </div>

        <!-- Message Modal -->
        <contact-message-modal
            v-if="selectedMessage"
            v-model:show="showModal"
            :message="selectedMessage"
            @updated="handleMessageUpdated"
        />
    </div>
</template>
