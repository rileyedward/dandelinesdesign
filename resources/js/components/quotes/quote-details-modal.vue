<script setup lang="ts">
import { QuoteMessage } from '@/types/models/quote-message';
import { formatDate } from '@/utils/date';
import { Check, X } from 'lucide-vue-next';
import { ref, watch } from 'vue';

interface Props {
    quote: QuoteMessage | null;
    isOpen: boolean;
    isRead?: boolean;
}

interface Emits {
    (e: 'close'): void;
    (e: 'markAsRead', id: number): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const isVisible = ref(false);

watch(
    () => props.isOpen,
    (newValue) => {
        if (newValue) {
            setTimeout(() => {
                isVisible.value = true;
            }, 50);
        } else {
            isVisible.value = false;
        }
    },
    { immediate: true },
);

const closeModal = () => {
    isVisible.value = false;
    setTimeout(() => {
        emit('close');
    }, 300);
};

const handleMarkAsRead = () => {
    if (props.quote) {
        emit('markAsRead', props.quote.id);
        closeModal();
    }
};
</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div
                class="fixed inset-0 bg-gray-500 transition-opacity"
                :class="{ 'bg-opacity-75': isVisible, 'bg-opacity-0': !isVisible }"
                @click="closeModal"
                aria-hidden="true"
            ></div>

            <!-- Modal panel -->
            <div
                class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl sm:align-middle"
                :class="{ 'translate-y-0 opacity-100': isVisible, 'translate-y-4 opacity-0': !isVisible }"
            >
                <div v-if="quote" class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                            <h3 class="text-2xl leading-6 font-bold text-gray-900" id="modal-title">
                                {{ quote.event_type }}
                            </h3>

                            <div class="mt-6 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <!-- Contact Information -->
                                <div class="sm:col-span-2">
                                    <h4 class="text-lg font-semibold text-gray-900">Contact Information</h4>
                                    <div class="mt-2 grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Name</p>
                                            <p class="text-base text-gray-900">{{ quote.name }}</p>
                                        </div>
                                        <div v-if="quote.business_name">
                                            <p class="text-sm font-medium text-gray-500">Business Name</p>
                                            <p class="text-base text-gray-900">{{ quote.business_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Email</p>
                                            <p class="text-base text-gray-900">
                                                <a :href="`mailto:${quote.email}`" class="text-blue-600 hover:underline">{{ quote.email }}</a>
                                            </p>
                                        </div>
                                        <div v-if="quote.phone">
                                            <p class="text-sm font-medium text-gray-500">Phone</p>
                                            <p class="text-base text-gray-900">
                                                <a :href="`tel:${quote.phone}`" class="text-blue-600 hover:underline">{{ quote.phone }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Event Details -->
                                <div class="sm:col-span-2">
                                    <h4 class="text-lg font-semibold text-gray-900">Event Details</h4>
                                    <div class="mt-2 grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Event Type</p>
                                            <p class="text-base text-gray-900">{{ quote.event_type }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Event Date</p>
                                            <p class="text-base text-gray-900">{{ formatDate(quote.event_date, true) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Guest Count</p>
                                            <p class="text-base text-gray-900">{{ quote.guest_count }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Budget Range</p>
                                            <p class="text-base text-gray-900">{{ quote.budget_range }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Venue Information -->
                                <div class="sm:col-span-2" v-if="quote.venue_name || quote.venue_address">
                                    <h4 class="text-lg font-semibold text-gray-900">Venue Information</h4>
                                    <div class="mt-2 grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                                        <div v-if="quote.venue_name">
                                            <p class="text-sm font-medium text-gray-500">Venue Name</p>
                                            <p class="text-base text-gray-900">{{ quote.venue_name }}</p>
                                        </div>
                                        <div v-if="quote.venue_address">
                                            <p class="text-sm font-medium text-gray-500">Venue Address</p>
                                            <p class="text-base text-gray-900">{{ quote.venue_address }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Event Description -->
                                <div class="sm:col-span-2">
                                    <h4 class="text-lg font-semibold text-gray-900">Event Description</h4>
                                    <div class="mt-2">
                                        <p class="text-base whitespace-pre-line text-gray-900">{{ quote.event_description }}</p>
                                    </div>
                                </div>

                                <!-- Special Requests -->
                                <div class="sm:col-span-2" v-if="quote.special_requests">
                                    <h4 class="text-lg font-semibold text-gray-900">Special Requests</h4>
                                    <div class="mt-2">
                                        <p class="text-base whitespace-pre-line text-gray-900">{{ quote.special_requests }}</p>
                                    </div>
                                </div>

                                <!-- Submission Info -->
                                <div class="sm:col-span-2">
                                    <h4 class="text-lg font-semibold text-gray-900">Submission Information</h4>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Received: {{ formatDate(quote.created_at) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button
                        type="button"
                        class="inline-flex justify-center rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none sm:ml-3"
                        @click="closeModal"
                        title="Close"
                    >
                        <X class="h-5 w-5" />
                    </button>
                    <button
                        v-if="quote && !isRead"
                        type="button"
                        class="inline-flex justify-center rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none sm:ml-3"
                        @click="handleMarkAsRead"
                        title="Mark as Read"
                    >
                        <Check class="h-5 w-5" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
