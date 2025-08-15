<script setup lang="ts">
import CheckoutProductList from '@/components/cart/checkout-product-list/checkout-product-list.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiDrawer from '@/components/ui/layout/drawer/ui-drawer.vue';
import { useCart } from '@/composables/useCart';
import { CreditCardIcon, Trash2Icon } from 'lucide-vue-next';

interface Props {
    show: boolean;
}

interface Emits {
    'update:show': [value: boolean];
    checkout: [];
}

defineProps<Props>();
const emit = defineEmits<Emits>();

const { cart, formatCurrency, updateQuantity, removeFromCart, clearCart } = useCart();

const handleUpdateQuantity = (itemId: string, quantity: number) => {
    updateQuantity(itemId, quantity);
};

const handleRemoveItem = (itemId: string) => {
    removeFromCart(itemId);
};

const handleClearCart = () => {
    if (confirm('Are you sure you want to clear your cart?')) {
        clearCart();
    }
};

const handleCheckout = () => {
    emit('checkout');
};

const handleUpdateShow = (value: boolean) => {
    emit('update:show', value);
};
</script>

<template>
    <ui-drawer
        :show="show"
        title="Shopping Cart"
        :description="`${cart.totalItems} item${cart.totalItems !== 1 ? 's' : ''} in your cart`"
        width="500px"
        @update:show="handleUpdateShow"
    >
        <div class="flex h-full flex-col">
            <!-- Header Actions -->
            <div v-if="cart.items.length > 0" class="mb-4 flex items-center justify-between border-b border-gray-200 pb-4">
                <p class="text-sm font-medium text-gray-900">{{ cart.totalItems }} item{{ cart.totalItems !== 1 ? 's' : '' }}</p>
                <ui-button @click="handleClearCart" variant="outline" size="sm" :icon="Trash2Icon" class="text-red-600 hover:text-red-700">
                    Clear Cart
                </ui-button>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto">
                <checkout-product-list :items="cart.items" @update-quantity="handleUpdateQuantity" @remove="handleRemoveItem" />
            </div>

            <!-- Cart Summary & Checkout -->
            <div v-if="cart.items.length > 0" class="mt-4 space-y-4 border-t border-gray-200 pt-4">
                <!-- Order Summary -->
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium text-gray-600">Calculated at checkout</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax</span>
                        <span class="font-medium text-gray-600">Calculated at checkout</span>
                    </div>
                </div>

                <!-- Subtotal -->
                <div class="border-t border-gray-200 pt-2">
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Subtotal</span>
                        <span>{{ formatCurrency(cart.totalPrice) }}</span>
                    </div>
                </div>

                <ui-button @click="handleCheckout" variant="primary" size="lg" class="w-full" :icon="CreditCardIcon"> Proceed to Checkout </ui-button>
                <ui-button @click="handleUpdateShow(false)" variant="outline" size="md" class="w-full"> Continue Shopping </ui-button>
            </div>
        </div>
    </ui-drawer>
</template>
