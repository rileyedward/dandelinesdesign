<script setup lang="ts">
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiCard from '@/components/ui/layout/card/ui-card.vue';
import type { Order } from '@/types/order';
import { router } from '@inertiajs/vue3';
import { BarChart3, Edit, Package } from 'lucide-vue-next';
import { reactive, ref } from 'vue';

interface Props {
    order: Order;
}

const props = defineProps<Props>();

const isModalOpen = ref(false);
const isUpdating = ref(false);
const selectedProduct = ref<any>(null);

const form = reactive({
    stock_quantity: 0,
    adjustment_reason: '',
});

const openModal = (product: any) => {
    selectedProduct.value = product;
    form.stock_quantity = product.stock_quantity;
    form.adjustment_reason = '';
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    selectedProduct.value = null;
};

const updateStock = () => {
    if (isUpdating.value || !selectedProduct.value) return;

    isUpdating.value = true;

    router.patch(
        route('admin.products.update', selectedProduct.value.id),
        {
            stock_quantity: form.stock_quantity,
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

const getProductsWithStock = () => {
    return props.order.line_items
        .filter((item) => item.product)
        .map((item) => ({
            ...item.product,
            ordered_quantity: item.quantity,
            total_sold: item.product?.total_quantity_sold || 0,
        }));
};

const getStockStatus = (product: any) => {
    if (product.stock_quantity === 0) {
        return { label: 'Out of Stock', color: 'text-red-600', bgColor: 'bg-red-50' };
    } else if (product.stock_quantity <= 2) {
        return { label: 'Low Stock', color: 'text-amber-600', bgColor: 'bg-amber-50' };
    } else {
        return { label: 'In Stock', color: 'text-green-600', bgColor: 'bg-green-50' };
    }
};
</script>

<template>
    <ui-card>
        <template #header>
            <div class="flex items-center gap-2">
                <Package class="h-5 w-5" />
                <span class="font-medium">Inventory Information</span>
            </div>
        </template>

        <div class="space-y-4">
            <!-- Products in this order -->
            <div v-if="getProductsWithStock().length > 0" class="space-y-3">
                <div
                    v-for="product in getProductsWithStock()"
                    :key="product.id"
                    class="flex items-center justify-between rounded-lg border bg-gray-50 p-3"
                >
                    <div class="flex flex-1 items-center gap-3">
                        <Package class="h-5 w-5 text-gray-600" />
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ product.name }}</p>
                            <div class="mt-1 flex items-center gap-4 text-sm text-gray-600">
                                <span>Ordered: {{ product.ordered_quantity }}</span>
                                <span>Current Stock: {{ product.stock_quantity }}</span>
                                <div class="flex items-center gap-1" :class="getStockStatus(product).color">
                                    <div class="h-2 w-2 rounded-full" :class="getStockStatus(product).bgColor"></div>
                                    <span>{{ getStockStatus(product).label }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ui-button @click="openModal(product)" variant="outline" size="sm" :prefix-icon="Edit" label="Adjust Stock" />
                </div>
            </div>

            <!-- Empty state -->
            <div v-else class="py-6 text-center text-gray-500">
                <Package class="mx-auto mb-2 h-8 w-8 text-gray-400" />
                <p class="text-sm">No product inventory information available</p>
                <p class="text-xs text-gray-400">Products in this order don't have inventory tracking</p>
            </div>

            <!-- Summary Stats -->
            <div v-if="getProductsWithStock().length > 0" class="border-t pt-4">
                <div class="mb-3 flex items-center gap-2">
                    <BarChart3 class="h-4 w-4 text-gray-600" />
                    <span class="text-sm font-medium text-gray-700">Order Impact</span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="rounded bg-blue-50 p-2 text-center">
                        <div class="font-medium text-blue-900">{{ getProductsWithStock().reduce((sum, p) => sum + p.ordered_quantity, 0) }}</div>
                        <div class="text-blue-600">Total Items Ordered</div>
                    </div>
                    <div class="rounded bg-green-50 p-2 text-center">
                        <div class="font-medium text-green-900">{{ getProductsWithStock().reduce((sum, p) => sum + p.stock_quantity, 0) }}</div>
                        <div class="text-green-600">Remaining Stock</div>
                    </div>
                </div>
            </div>
        </div>
    </ui-card>

    <!-- Stock Adjustment Modal -->
    <ui-modal :show="isModalOpen" @update:show="isModalOpen = $event" title="Adjust Product Stock" size="md">
        <div v-if="selectedProduct" class="space-y-4">
            <div class="rounded-lg bg-gray-50 p-3">
                <p class="font-medium text-gray-900">{{ selectedProduct.name }}</p>
                <p class="text-sm text-gray-600">Current stock: {{ selectedProduct.stock_quantity }} items</p>
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
                placeholder="e.g., Inventory count correction, damaged items, etc."
                help-text="Optional note about why stock is being adjusted"
            />
        </div>

        <template #footer>
            <div class="flex gap-3">
                <ui-button @click="closeModal" variant="outline" label="Cancel" :disabled="isUpdating" />
                <ui-button @click="updateStock" label="Update Stock" :loading="isUpdating" />
            </div>
        </template>
    </ui-modal>
</template>
