<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import { useCart } from '@/composables/useCart';
import type { CartItem } from '@/types/cart';
import { ImageIcon, MinusIcon, PlusIcon, Trash2Icon } from 'lucide-vue-next';

interface Props {
    item: CartItem;
}

interface Emits {
    'update-quantity': [itemId: string, quantity: number];
    remove: [itemId: string];
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const { formatCurrency } = useCart();

const increaseQuantity = () => {
    if (props.item.quantity < props.item.product.stock_quantity) {
        emit('update-quantity', props.item.id, props.item.quantity + 1);
    }
};

const decreaseQuantity = () => {
    if (props.item.quantity > 1) {
        emit('update-quantity', props.item.id, props.item.quantity - 1);
    }
};

const isAtMaxQuantity = () => {
    return props.item.quantity >= props.item.product.stock_quantity;
};

const removeItem = () => {
    emit('remove', props.item.id);
};

const itemTotal = () => {
    return props.item.price.unit_amount * props.item.quantity;
};
</script>

<template>
    <div class="flex items-center space-x-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
        <!-- Product Image -->
        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
            <img
                v-if="item.product.images?.length ? item.product.images[0] : item.product.image_url"
                :src="item.product.images?.length ? item.product.images[0] : item.product.image_url"
                :alt="item.product.name"
                class="h-full w-full object-cover object-center"
            />
            <div v-else class="flex h-full w-full items-center justify-center text-gray-400">
                <ImageIcon class="h-6 w-6" />
            </div>
        </div>

        <!-- Product Details -->
        <div class="flex-1 space-y-1">
            <h3 class="line-clamp-1 text-sm font-medium text-gray-900">
                {{ item.product.name }}
            </h3>
            <p class="text-sm text-gray-600">{{ formatCurrency(item.price.unit_amount) }} each</p>
            <p v-if="item.price.nickname" class="text-xs text-gray-500">
                {{ item.price.nickname }}
            </p>
            <p v-if="item.product.stock_quantity <= 2" class="text-xs text-amber-600">Only {{ item.product.stock_quantity }} available</p>
        </div>

        <!-- Quantity Controls -->
        <div class="flex items-center space-x-2">
            <button
                @click="decreaseQuantity"
                :disabled="item.quantity <= 1"
                class="flex h-8 w-8 items-center justify-center rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <MinusIcon class="h-4 w-4" />
            </button>
            <span class="w-8 text-center text-sm font-medium">{{ item.quantity }}</span>
            <button
                @click="increaseQuantity"
                :disabled="isAtMaxQuantity()"
                class="flex h-8 w-8 items-center justify-center rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <PlusIcon class="h-4 w-4" />
            </button>
        </div>

        <!-- Price and Remove -->
        <div class="flex flex-col items-end space-y-2">
            <span class="text-sm font-semibold text-gray-900">
                {{ formatCurrency(itemTotal()) }}
            </span>
            <UiButton @click="removeItem" variant="outline" size="xs" :icon="Trash2Icon" class="text-red-600 hover:text-red-700"> Remove </UiButton>
        </div>
    </div>
</template>

<style scoped>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
