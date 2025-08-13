<script setup lang="ts">
import QuoteRequestBanner from '@/components/quote-request/quote-request-banner/quote-request-banner.vue';
import QuoteRequestUpdateModal from '@/components/quote-request/quote-request-update-modal/quote-request-update-modal.vue';
import type { TabItem } from '@/components/ui/navigation/tab/ui-tab';
import UiTab from '@/components/ui/navigation/tab/ui-tab.vue';
import type { QuoteRequest } from '@/types/quote-request';
import { Clock, DollarSign, MessageSquare, Phone } from 'lucide-vue-next';
import { ref } from 'vue';
import type { QuoteRequestListProps as Props } from './quote-request-list';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No quote requests found',
    loadingText: 'Loading quote requests...',
});

const selectedTab = ref('pending');
const showUpdateModal = ref(false);
const selectedQuoteRequest = ref<QuoteRequest | null>(null);

const tabs: TabItem[] = [
    { label: `Pending (${props.pendingRequests.length})`, value: 'pending', icon: Clock },
    { label: `Contacted (${props.contactedRequests.length})`, value: 'contacted', icon: Phone },
    { label: `Quoted (${props.quotedRequests.length})`, value: 'quoted', icon: DollarSign },
    { label: `Completed (${props.completedRequests.length})`, value: 'completed', icon: MessageSquare },
    { label: `Cancelled (${props.cancelledRequests.length})`, value: 'cancelled', icon: MessageSquare },
];

const handleQuoteRequestClick = (quoteRequest: QuoteRequest) => {
    selectedQuoteRequest.value = quoteRequest;
    showUpdateModal.value = true;
};

const handleQuoteRequestUpdated = () => {
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
                    <div v-if="activeTab?.value === 'pending'" class="mt-6 space-y-6">
                        <div v-if="pendingRequests.length === 0" class="py-8 text-center text-gray-500">No pending quote requests</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div
                                v-for="request in pendingRequests"
                                :key="request.id"
                                class="cursor-pointer"
                                @click="handleQuoteRequestClick(request)"
                            >
                                <quote-request-banner :request="request" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'contacted'" class="mt-6 space-y-6">
                        <div v-if="contactedRequests.length === 0" class="py-8 text-center text-gray-500">No contacted quote requests</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div
                                v-for="request in contactedRequests"
                                :key="request.id"
                                class="cursor-pointer"
                                @click="handleQuoteRequestClick(request)"
                            >
                                <quote-request-banner :request="request" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'quoted'" class="mt-6 space-y-6">
                        <div v-if="quotedRequests.length === 0" class="py-8 text-center text-gray-500">No quoted quote requests</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div v-for="request in quotedRequests" :key="request.id" class="cursor-pointer" @click="handleQuoteRequestClick(request)">
                                <quote-request-banner :request="request" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'completed'" class="mt-6 space-y-6">
                        <div v-if="completedRequests.length === 0" class="py-8 text-center text-gray-500">No completed quote requests</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div
                                v-for="request in completedRequests"
                                :key="request.id"
                                class="cursor-pointer"
                                @click="handleQuoteRequestClick(request)"
                            >
                                <quote-request-banner :request="request" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'cancelled'" class="mt-6 space-y-6">
                        <div v-if="cancelledRequests.length === 0" class="py-8 text-center text-gray-500">No cancelled quote requests</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div
                                v-for="request in cancelledRequests"
                                :key="request.id"
                                class="cursor-pointer"
                                @click="handleQuoteRequestClick(request)"
                            >
                                <quote-request-banner :request="request" />
                            </div>
                        </div>
                    </div>
                </template>
            </UiTab>
        </div>

        <quote-request-update-modal
            v-if="selectedQuoteRequest"
            v-model:show="showUpdateModal"
            :quote-request="selectedQuoteRequest"
            @updated="handleQuoteRequestUpdated"
        />
    </div>
</template>
