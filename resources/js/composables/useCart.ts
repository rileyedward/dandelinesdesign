import type { Cart, CartItem } from '@/types/cart';
import type { Product } from '@/types/product';
import { computed, reactive } from 'vue';

const cartState = reactive<Cart>({
    items: [],
    isOpen: false,
    totalItems: 0,
    totalPrice: 0,
});

export function useCart() {
    const generateCartItemId = (productId: number, priceId: number): string => {
        return `${productId}-${priceId}`;
    };

    const addToCart = (product: Product, quantity: number = 1): void => {
        // Check stock availability
        if (product.stock_quantity === 0) {
            console.error('Product is out of stock');
            return;
        }

        // First try to find the current price
        let price = product.prices?.find((price) => price.is_current);

        // Fall back to the first price if no current price is set
        if (!price) {
            price = product.prices?.[0];
        }

        if (!price) {
            console.error('Product has no price available');
            return;
        }

        const itemId = generateCartItemId(product.id, price.id);
        const existingItem = cartState.items.find((item) => item.id === itemId);

        if (existingItem) {
            // Respect stock limits when adding to existing item
            const newQuantity = Math.min(existingItem.quantity + quantity, product.stock_quantity);
            existingItem.quantity = newQuantity;
        } else {
            // Respect stock limits for new items
            const finalQuantity = Math.min(quantity, product.stock_quantity);
            const newItem: CartItem = {
                id: itemId,
                product,
                price,
                quantity: finalQuantity,
                addedAt: new Date(),
            };
            cartState.items.push(newItem);
        }

        updateCartTotals();
    };

    const removeFromCart = (itemId: string): void => {
        const index = cartState.items.findIndex((item) => item.id === itemId);
        if (index > -1) {
            cartState.items.splice(index, 1);
            updateCartTotals();
        }
    };

    const updateQuantity = (itemId: string, quantity: number): void => {
        const item = cartState.items.find((item) => item.id === itemId);
        if (item) {
            if (quantity <= 0) {
                removeFromCart(itemId);
            } else {
                // Respect stock limits when updating quantity
                item.quantity = Math.min(quantity, item.product.stock_quantity);
                updateCartTotals();
            }
        }
    };

    const clearCart = (): void => {
        cartState.items = [];
        updateCartTotals();
    };

    const updateCartTotals = (): void => {
        cartState.totalItems = cartState.items.reduce((total, item) => total + item.quantity, 0);
        cartState.totalPrice = cartState.items.reduce((total, item) => total + item.price.unit_amount * item.quantity, 0);
    };

    const openCart = (): void => {
        cartState.isOpen = true;
    };

    const closeCart = (): void => {
        cartState.isOpen = false;
    };

    const toggleCart = (): void => {
        cartState.isOpen = !cartState.isOpen;
    };

    const hasItems = computed(() => cartState.totalItems > 0);

    const formatCurrency = (amount: number): string => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        }).format(amount);
    };

    return {
        // State
        cart: cartState,
        hasItems,

        // Actions
        addToCart,
        removeFromCart,
        updateQuantity,
        clearCart,
        openCart,
        closeCart,
        toggleCart,

        // Utilities
        formatCurrency,
    };
}
