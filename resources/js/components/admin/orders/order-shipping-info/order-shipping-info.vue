<script setup lang="ts">
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiCard from '@/components/ui/layout/card/ui-card.vue';
import type { Order } from '@/types/order';
import { router } from '@inertiajs/vue3';
import { Edit, MapPin, Package, Truck } from 'lucide-vue-next';
import { reactive, ref } from 'vue';

interface Props {
    order: Order;
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

            <!-- Placeholder for Shipping Updates -->
            <div class="border-t pt-4">
                <div class="mb-2 flex items-center gap-2">
                    <div class="h-2 w-2 rounded-full bg-gray-300"></div>
                    <span class="text-sm font-medium text-gray-600">Shipping Updates</span>
                </div>
                <div class="text-sm text-gray-400 italic">Tracking updates will appear here when available</div>
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
