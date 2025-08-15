<script setup lang="ts">
import CheckoutProductBanner from '@/components/cart/checkout-product-banner/checkout-product-banner.vue';
import type { CartItem } from '@/types/cart';
import { ShoppingCartIcon } from 'lucide-vue-next';

interface Props {
    items: CartItem[];
}

interface Emits {
    'update-quantity': [itemId: string, quantity: number];
    remove: [itemId: string];
}

defineProps<Props>();
const emit = defineEmits<Emits>();

const handleUpdateQuantity = (itemId: string, quantity: number) => {
    emit('update-quantity', itemId, quantity);
};

const handleRemoveItem = (itemId: string) => {
    emit('remove', itemId);
};
</script>

<template>
    <div class="space-y-4">
        <!-- Cart Items -->
        <template v-if="items.length > 0">
            <CheckoutProductBanner
                v-for="item in items"
                :key="item.id"
                :item="item"
                @update-quantity="handleUpdateQuantity"
                @remove="handleRemoveItem"
            />
        </template>

        <!-- Empty State -->
        <div v-else class="flex flex-col items-center justify-center py-12 text-center">
            <div class="text-gray-400">
                <ShoppingCartIcon class="mx-auto mb-4 h-12 w-12" />
                <p class="text-lg font-medium text-gray-900">Your cart is empty</p>
                <p class="mt-1 text-sm text-gray-500">Add some products to get started!</p>
            </div>
        </div>
    </div>
</template>
