<script setup lang="ts">
import NewsletterSubscriberBanner from '@/components/newsletter-subscriber/newsletter-subscriber-banner/newsletter-subscriber-banner.vue';
import NewsletterSubscriberModal from '@/components/newsletter-subscriber/newsletter-subscriber-modal/newsletter-subscriber-modal.vue';
import type { TabItem } from '@/components/ui/navigation/tab/ui-tab';
import UiTab from '@/components/ui/navigation/tab/ui-tab.vue';
import type { NewsletterSubscriber } from '@/types/newsletter-subscriber';
import { CheckCircle, UserX, Users } from 'lucide-vue-next';
import { ref } from 'vue';
import type { NewsletterSubscriberListProps as Props } from './newsletter-subscriber-list';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No subscribers found',
    loadingText: 'Loading subscribers...',
});

const selectedTab = ref('active');
const showModal = ref(false);
const selectedSubscriber = ref<NewsletterSubscriber | null>(null);

const tabs: TabItem[] = [
    { label: `Active (${props.activeSubscribers.length})`, value: 'active', icon: CheckCircle },
    { label: `Inactive (${props.inactiveSubscribers.length})`, value: 'inactive', icon: Users },
    { label: `Unsubscribed (${props.unsubscribedSubscribers.length})`, value: 'unsubscribed', icon: UserX },
];

const handleSubscriberClick = (subscriber: NewsletterSubscriber) => {
    selectedSubscriber.value = subscriber;
    showModal.value = true;
};

const handleSubscriberUpdated = () => {
    // Reload the page to refresh the subscriber lists
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
                    <div v-if="activeTab?.value === 'active'" class="mt-6 space-y-6">
                        <div v-if="activeSubscribers.length === 0" class="py-8 text-center text-gray-500">No active subscribers</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <div 
                                v-for="subscriber in activeSubscribers" 
                                :key="subscriber.id" 
                                class="cursor-pointer" 
                                @click="handleSubscriberClick(subscriber)"
                            >
                                <newsletter-subscriber-banner :subscriber="subscriber" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'inactive'" class="mt-6 space-y-6">
                        <div v-if="inactiveSubscribers.length === 0" class="py-8 text-center text-gray-500">No inactive subscribers</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <div 
                                v-for="subscriber in inactiveSubscribers" 
                                :key="subscriber.id" 
                                class="cursor-pointer" 
                                @click="handleSubscriberClick(subscriber)"
                            >
                                <newsletter-subscriber-banner :subscriber="subscriber" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'unsubscribed'" class="mt-6 space-y-6">
                        <div v-if="unsubscribedSubscribers.length === 0" class="py-8 text-center text-gray-500">No unsubscribed subscribers</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <div 
                                v-for="subscriber in unsubscribedSubscribers" 
                                :key="subscriber.id" 
                                class="cursor-pointer" 
                                @click="handleSubscriberClick(subscriber)"
                            >
                                <newsletter-subscriber-banner :subscriber="subscriber" />
                            </div>
                        </div>
                    </div>
                </template>
            </UiTab>
        </div>

        <!-- Subscriber Modal -->
        <newsletter-subscriber-modal 
            v-if="selectedSubscriber" 
            v-model:show="showModal" 
            :subscriber="selectedSubscriber" 
            @updated="handleSubscriberUpdated" 
        />
    </div>
</template>