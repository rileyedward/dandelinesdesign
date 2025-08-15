<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiSelect from '@/components/ui/forms/select/ui-select.vue';
import UiCard from '@/components/ui/layout/card/ui-card.vue';
import type { Order } from '@/types/order';
import { router } from '@inertiajs/vue3';
import { CheckCircle, Package, Truck, PackageCheck, XCircle, RefreshCcw } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    order: Order;
}

const props = defineProps<Props>();

const statusOptions = [
    { value: 'pending', label: 'Pending', icon: Package, color: 'text-amber-600', bgColor: 'bg-amber-50' },
    { value: 'processing', label: 'Processing', icon: RefreshCcw, color: 'text-blue-600', bgColor: 'bg-blue-50' },
    { value: 'shipped', label: 'Shipped', icon: Truck, color: 'text-purple-600', bgColor: 'bg-purple-50' },
    { value: 'delivered', label: 'Delivered', icon: PackageCheck, color: 'text-green-600', bgColor: 'bg-green-50' },
    { value: 'cancelled', label: 'Cancelled', icon: XCircle, color: 'text-red-600', bgColor: 'bg-red-50' },
    { value: 'refunded', label: 'Refunded', icon: RefreshCcw, color: 'text-gray-600', bgColor: 'bg-gray-50' },
];

const selectedStatus = ref(props.order.status);
const isUpdating = ref(false);

const getCurrentStatus = () => {
    return statusOptions.find(option => option.value === props.order.status);
};

const getQuickActions = () => {
    const currentStatus = props.order.status;
    const quickActions = [];

    if (currentStatus === 'pending') {
        quickActions.push(
            statusOptions.find(s => s.value === 'processing'),
            statusOptions.find(s => s.value === 'cancelled')
        );
    } else if (currentStatus === 'processing') {
        quickActions.push(
            statusOptions.find(s => s.value === 'shipped'),
            statusOptions.find(s => s.value === 'cancelled')
        );
    } else if (currentStatus === 'shipped') {
        quickActions.push(
            statusOptions.find(s => s.value === 'delivered')
        );
    } else if (currentStatus === 'delivered') {
        quickActions.push(
            statusOptions.find(s => s.value === 'refunded')
        );
    }

    return quickActions.filter(Boolean);
};

const updateStatus = (newStatus: string) => {
    if (newStatus === props.order.status || isUpdating.value) return;

    isUpdating.value = true;
    
    router.patch(route('admin.orders.update', props.order.id), {
        status: newStatus
    }, {
        preserveScroll: true,
        onFinish: () => {
            isUpdating.value = false;
        }
    });
};

const updateFromSelect = () => {
    updateStatus(selectedStatus.value);
};
</script>

<template>
    <ui-card>
        <template #header>
            <div class="flex items-center gap-2">
                <component :is="getCurrentStatus()?.icon" class="h-5 w-5" />
                <span class="font-medium">Order Status</span>
            </div>
        </template>

        <div class="space-y-4">
            <!-- Current Status Display -->
            <div class="flex items-center gap-3 p-3 rounded-lg border" :class="getCurrentStatus()?.bgColor">
                <component :is="getCurrentStatus()?.icon" class="h-5 w-5" :class="getCurrentStatus()?.color" />
                <div>
                    <p class="font-medium" :class="getCurrentStatus()?.color">
                        {{ getCurrentStatus()?.label }}
                    </p>
                    <p class="text-sm text-gray-500">Current status</p>
                </div>
            </div>

            <!-- Quick Action Buttons -->
            <div v-if="getQuickActions().length > 0" class="space-y-2">
                <p class="text-sm font-medium text-gray-700">Quick Actions</p>
                <div class="flex flex-wrap gap-2">
                    <ui-button
                        v-for="action in getQuickActions()"
                        :key="action.value"
                        @click="updateStatus(action.value)"
                        :disabled="isUpdating"
                        size="sm"
                        variant="outline"
                        :prefix-icon="action.icon"
                        :label="`Mark as ${action.label}`"
                    />
                </div>
            </div>

            <!-- Status Selector -->
            <div class="space-y-2">
                <p class="text-sm font-medium text-gray-700">Change Status</p>
                <div class="flex gap-2">
                    <div class="flex-1">
                        <ui-select
                            v-model="selectedStatus"
                            :options="statusOptions.map(opt => ({ value: opt.value, label: opt.label }))"
                            placeholder="Select status..."
                        />
                    </div>
                    <ui-button
                        @click="updateFromSelect"
                        :disabled="selectedStatus === order.status || isUpdating"
                        size="sm"
                        label="Update"
                    />
                </div>
            </div>
        </div>
    </ui-card>
</template>