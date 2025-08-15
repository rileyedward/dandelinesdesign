<script setup lang="ts">
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiCard from '@/components/ui/layout/card/ui-card.vue';
import { router } from '@inertiajs/vue3';
import { Edit, Package, AlertTriangle, CheckCircle } from 'lucide-vue-next';
import { reactive, ref } from 'vue';

interface Product {
    id: number;
    name: string;
    stock_quantity: number;
}

interface Props {
    product: Product;
}

const props = defineProps<Props>();

const isModalOpen = ref(false);
const isUpdating = ref(false);

const form = reactive({
    stock_quantity: props.product.stock_quantity,
    adjustment_reason: '',
});

const openModal = () => {
    form.stock_quantity = props.product.stock_quantity;
    form.adjustment_reason = '';
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const updateStock = () => {
    if (isUpdating.value) return;

    isUpdating.value = true;
    
    router.patch(route('admin.products.update', props.product.id), {
        stock_quantity: form.stock_quantity,
    }, {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
        },
        onFinish: () => {
            isUpdating.value = false;
        }
    });
};

const getStockStatus = () => {
    if (props.product.stock_quantity === 0) {
        return { 
            label: 'Out of Stock', 
            color: 'text-red-600', 
            bgColor: 'bg-red-50',
            icon: AlertTriangle
        };
    } else if (props.product.stock_quantity <= 2) {
        return { 
            label: 'Low Stock', 
            color: 'text-amber-600', 
            bgColor: 'bg-amber-50',
            icon: AlertTriangle
        };
    } else {
        return { 
            label: 'In Stock', 
            color: 'text-green-600', 
            bgColor: 'bg-green-50',
            icon: CheckCircle
        };
    }
};
</script>

<template>
    <ui-card>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <Package class="h-5 w-5" />
                    <span class="font-medium">Stock Management</span>
                </div>
                <ui-button
                    @click="openModal"
                    variant="outline"
                    size="sm"
                    :prefix-icon="Edit"
                    label="Update Stock"
                />
            </div>
        </template>

        <div class="space-y-4">
            <!-- Current Stock Display -->
            <div class="flex items-center gap-3 p-3 rounded-lg border" :class="getStockStatus().bgColor">
                <component :is="getStockStatus().icon" class="h-5 w-5" :class="getStockStatus().color" />
                <div class="flex-1">
                    <p class="font-medium text-lg" :class="getStockStatus().color">
                        {{ product.stock_quantity }} {{ product.stock_quantity === 1 ? 'item' : 'items' }}
                    </p>
                    <p class="text-sm" :class="getStockStatus().color">
                        {{ getStockStatus().label }}
                    </p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-2">
                <p class="text-sm font-medium text-gray-700">Quick Actions</p>
                <div class="flex gap-2">
                    <ui-button
                        @click="form.stock_quantity = 0; updateStock()"
                        :disabled="product.stock_quantity === 0 || isUpdating"
                        size="sm"
                        variant="outline"
                        label="Mark Out of Stock"
                    />
                    <ui-button
                        @click="form.stock_quantity = 1; updateStock()"
                        :disabled="product.stock_quantity === 1 || isUpdating"
                        size="sm"
                        variant="outline"
                        label="Set to 1"
                    />
                </div>
            </div>
        </div>
    </ui-card>

    <!-- Stock Update Modal -->
    <ui-modal :show="isModalOpen" @update:show="isModalOpen = $event" title="Update Product Stock" size="md">
        <div class="space-y-4">
            <div class="p-3 bg-gray-50 rounded-lg">
                <p class="font-medium text-gray-900">{{ product.name }}</p>
                <p class="text-sm text-gray-600">Current stock: {{ product.stock_quantity }} {{ product.stock_quantity === 1 ? 'item' : 'items' }}</p>
            </div>

            <ui-input
                v-model.number="form.stock_quantity"
                label="New Stock Quantity"
                type="number"
                min="0"
                placeholder="Enter new stock quantity"
                help-text="Set the total available stock for this product"
            />

            <ui-input
                v-model="form.adjustment_reason"
                label="Adjustment Reason (Optional)"
                placeholder="e.g., Inventory count correction, item sold offline, etc."
                help-text="Optional note about why stock is being adjusted"
            />
        </div>

        <template #footer>
            <div class="flex gap-3">
                <ui-button
                    @click="closeModal"
                    variant="outline"
                    label="Cancel"
                    :disabled="isUpdating"
                />
                <ui-button
                    @click="updateStock"
                    label="Update Stock"
                    :loading="isUpdating"
                />
            </div>
        </template>
    </ui-modal>
</template>