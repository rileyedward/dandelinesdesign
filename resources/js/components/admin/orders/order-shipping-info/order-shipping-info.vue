<script setup lang="ts">
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiCard from '@/components/ui/layout/card/ui-card.vue';
import type { Order } from '@/types/order';
import type { TrackingData } from '@/types/tracking';
import { router } from '@inertiajs/vue3';
import { CheckCircle, Clock, Edit, MapPin, Package, RefreshCw, Truck, XCircle } from 'lucide-vue-next';
import { reactive, ref } from 'vue';

interface Props {
    order: Order;
    trackingData?: TrackingData | null;
}

const props = defineProps<Props>();

const isModalOpen = ref(false);
const isUpdating = ref(false);

const form = reactive({
    shipping_method: props.order.shipping_method || '',
    tracking_number: props.order.tracking_number || '',
});

const openModal = () => {
    form.shipping_method = props.order.shipping_method || '';
    form.tracking_number = props.order.tracking_number || '';
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const updateShipping = () => {
    if (isUpdating.value) return;

    isUpdating.value = true;

    router.patch(
        route('admin.orders.update', props.order.id),
        {
            shipping_method: form.shipping_method,
            tracking_number: form.tracking_number,
            status: 'shipped',
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
            },
            onFinish: () => {
                isUpdating.value = false;
            },
        },
    );
};

const hasShippingInfo = () => {
    return props.order.shipping_method || props.order.tracking_number;
};

const refreshTracking = () => {
    router.reload({ only: ['trackingData'] });
};

const getStatusIcon = (status: string) => {
    const statusLower = status.toLowerCase();
    if (statusLower.includes('delivered')) return CheckCircle;
    if (statusLower.includes('out for delivery')) return Truck;
    if (statusLower.includes('error')) return XCircle;
    return Clock;
};

const getStatusColor = (status: string) => {
    const statusLower = status.toLowerCase();
    if (statusLower.includes('delivered')) return 'text-green-600';
    if (statusLower.includes('out for delivery')) return 'text-blue-600';
    if (statusLower.includes('error')) return 'text-red-600';
    return 'text-gray-600';
};

const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
};

const formatTime = (timeString: string) => {
    if (!timeString) return '';
    const [hours, minutes] = timeString.split(':');
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour % 12 || 12;
    return `${displayHour}:${minutes} ${ampm}`;
};
</script>

<template>
    <ui-card>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <Truck class="h-5 w-5" />
                    <span class="font-medium">Shipping Information</span>
                </div>
                <ui-button @click="openModal" variant="outline" size="sm" :prefix-icon="Edit" label="Update Shipping" />
            </div>
        </template>

        <div class="space-y-4">
            <!-- Current Shipping Info Display -->
            <div v-if="hasShippingInfo()" class="space-y-3">
                <div v-if="order.shipping_method" class="flex items-center gap-3 rounded-lg border bg-blue-50 p-3">
                    <Package class="h-5 w-5 text-blue-600" />
                    <div>
                        <p class="font-medium text-blue-900">{{ order.shipping_method }}</p>
                        <p class="text-sm text-blue-600">Shipping Method</p>
                    </div>
                </div>

                <div v-if="order.tracking_number" class="flex items-center gap-3 rounded-lg border bg-green-50 p-3">
                    <MapPin class="h-5 w-5 text-green-600" />
                    <div>
                        <p class="font-mono font-medium text-green-900">{{ order.tracking_number }}</p>
                        <p class="text-sm text-green-600">Tracking Number</p>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="py-6 text-center text-gray-500">
                <Truck class="mx-auto mb-2 h-8 w-8 text-gray-400" />
                <p class="text-sm">No shipping information available</p>
                <p class="text-xs text-gray-400">Click "Update Shipping" to add details</p>
            </div>

            <!-- Shipping Updates / Tracking Timeline -->
            <div class="border-t pt-4">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="h-2 w-2 rounded-full bg-gray-300"></div>
                        <span class="text-sm font-medium text-gray-600">Shipping Updates</span>
                    </div>
                    <ui-button 
                        v-if="order.tracking_number && trackingData"
                        @click="refreshTracking"
                        variant="outline"
                        size="sm"
                        :prefix-icon="RefreshCw"
                        label="Refresh"
                    />
                </div>

                <!-- Tracking Timeline -->
                <div v-if="trackingData && trackingData.events.length > 0" class="space-y-4">
                    <!-- Current Status Summary -->
                    <div v-if="trackingData.status !== 'Error'" class="rounded-lg border bg-blue-50 p-4">
                        <div class="flex items-center gap-3">
                            <component :is="getStatusIcon(trackingData.status)" :class="['h-5 w-5', getStatusColor(trackingData.status)]" />
                            <div>
                                <p class="font-medium text-blue-900">{{ trackingData.status }}</p>
                                <p v-if="trackingData.expected_delivery" class="text-sm text-blue-600">
                                    Expected delivery: {{ formatDate(trackingData.expected_delivery) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tracking Events Timeline -->
                    <div class="space-y-3">
                        <div 
                            v-for="(event, index) in trackingData.events" 
                            :key="index"
                            class="flex gap-4 pb-3"
                            :class="{ 'border-b': index < trackingData.events.length - 1 }"
                        >
                            <!-- Timeline dot -->
                            <div class="flex flex-col items-center">
                                <component 
                                    :is="getStatusIcon(event.status)" 
                                    :class="['h-4 w-4 mt-0.5', getStatusColor(event.status)]" 
                                />
                                <div 
                                    v-if="index < trackingData.events.length - 1" 
                                    class="w-px h-8 bg-gray-200 mt-2"
                                ></div>
                            </div>

                            <!-- Event details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ event.status }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ event.description }}</p>
                                        <div v-if="event.location" class="flex items-center gap-1 mt-2">
                                            <MapPin class="h-3 w-3 text-gray-400" />
                                            <span class="text-xs text-gray-500">{{ event.location }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right text-xs text-gray-500 ml-4">
                                        <div>{{ formatDate(event.date) }}</div>
                                        <div v-if="event.time">{{ formatTime(event.time) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No tracking data available -->
                <div v-else-if="!order.tracking_number" class="text-sm text-gray-400 italic">
                    Add a tracking number to see shipping updates
                </div>

                <!-- Error state -->
                <div v-else-if="trackingData && trackingData.status === 'Error'" class="rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex items-center gap-3">
                        <XCircle class="h-5 w-5 text-red-600" />
                        <div>
                            <p class="font-medium text-red-900">Unable to fetch tracking information</p>
                            <p class="text-sm text-red-600">Please verify the tracking number or try again later</p>
                        </div>
                    </div>
                </div>

                <!-- Loading state -->
                <div v-else class="text-sm text-gray-400 italic">
                    Loading tracking information...
                </div>
            </div>
        </div>
    </ui-card>

    <!-- Update Shipping Modal -->
    <ui-modal :show="isModalOpen" @update:show="isModalOpen = $event" title="Update Shipping Information" size="md">
        <div class="space-y-4">
            <ui-input
                v-model="form.shipping_method"
                label="Shipping Method"
                placeholder="e.g., FedEx Ground, UPS Next Day, USPS Priority..."
                help-text="The shipping carrier and service type"
            />

            <ui-input
                v-model="form.tracking_number"
                label="Tracking Number"
                placeholder="e.g., 1Z999AA1234567890"
                help-text="The package tracking number from the carrier"
            />
        </div>

        <template #footer>
            <div class="flex gap-3">
                <ui-button @click="closeModal" variant="outline" label="Cancel" :disabled="isUpdating" />
                <ui-button @click="updateShipping" label="Update Shipping" :loading="isUpdating" />
            </div>
        </template>
    </ui-modal>
</template>
