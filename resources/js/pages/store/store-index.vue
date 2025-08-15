<script setup lang="ts">
import CartButton from '@/components/cart/cart-button/cart-button.vue';
import CartDrawer from '@/components/cart/cart-drawer/cart-drawer.vue';
import StoreProductList from '@/components/store/product-list/store-product-list.vue';
import StoreProductModal from '@/components/store/product-modal/store-product-modal.vue';
import StoreSplash from '@/components/store/store-splash.vue';
import type { StoreTabItem } from '@/components/store/store-tabs/store-tabs';
import StoreTabs from '@/components/store/store-tabs/store-tabs.vue';
import { useCart } from '@/composables/useCart';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import type { Category, Product } from '@/types/product';
import { Head } from '@inertiajs/vue3';
import { Grid, Package, Tag } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Props {
    products: Product[];
    categories: Category[];
}

const props = defineProps<Props>();

const activeTab = ref('all');
const selectedProduct = ref<Product | null>(null);
const showProductModal = ref(false);

const { addToCart, toggleCart, cart } = useCart();

const tabs = computed((): StoreTabItem[] => {
    const allTab: StoreTabItem = {
        label: 'All Products',
        value: 'all',
        icon: Grid,
        count: props.products.length,
    };

    const categoryTabs: StoreTabItem[] = props.categories
        .map((category) => ({
            label: category.name,
            value: category.id.toString(),
            icon: Tag,
            count: props.products.filter((product) => product.category_id === category.id).length,
        }))
        .filter((tab) => tab.count > 0); // Only show categories with products

    return [allTab, ...categoryTabs];
});

const filteredProducts = computed(() => {
    if (activeTab.value === 'all') {
        return props.products;
    }

    const categoryId = parseInt(activeTab.value);
    return props.products.filter((product) => product.category_id === categoryId);
});

const handleViewProduct = (product: Product) => {
    selectedProduct.value = product;
    showProductModal.value = true;
};

const handleCloseModal = () => {
    showProductModal.value = false;
    selectedProduct.value = null;
};

const handleAddToCart = (product: Product, quantity: number) => {
    addToCart(product, quantity);
    handleCloseModal();
};

const handleCartButtonClick = () => {
    toggleCart();
};

const handleCartDrawerClose = (value: boolean) => {
    cart.isOpen = value;
};

const handleCheckout = () => {
    const checkoutItems = cart.items.map((item) => ({
        price_id: item.price.stripe_price_id,
        quantity: item.quantity,
    }));

    cart.isOpen = false;

    // Create a form and submit it to allow proper redirect to Stripe
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = route('checkout.store');

    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    form.appendChild(csrfInput);

    // Add items data
    checkoutItems.forEach((item, index) => {
        const priceIdInput = document.createElement('input');
        priceIdInput.type = 'hidden';
        priceIdInput.name = `items[${index}][price_id]`;
        priceIdInput.value = item.price_id;
        form.appendChild(priceIdInput);

        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = `items[${index}][quantity]`;
        quantityInput.value = item.quantity.toString();
        form.appendChild(quantityInput);
    });

    document.body.appendChild(form);
    form.submit();
};
</script>

<template>
    <Head title="Store - Dandelines Design" />

    <navbar-layout>
        <store-splash />

        <section class="bg-gray-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 text-center">
                    <div
                        class="from-primary-100 to-primary-200 text-primary-800 mb-4 inline-flex items-center rounded-full bg-gradient-to-r px-4 py-2 text-sm font-medium"
                    >
                        <Package class="mr-2 h-4 w-4" />
                        Our Collection
                    </div>
                    <h2 class="mb-4 text-4xl font-bold text-gray-900">Beautiful Products for Every Occasion</h2>
                    <p class="mx-auto max-w-2xl text-xl text-gray-600">
                        Discover our carefully curated collection of handcrafted designs, elegant floral arrangements, and exclusive artwork.
                    </p>
                </div>

                <div class="mb-8">
                    <store-tabs v-model="activeTab" :items="tabs" />
                </div>

                <store-product-list :products="filteredProducts" @view="handleViewProduct" />
            </div>
        </section>

        <!-- Product Modal -->
        <StoreProductModal :show="showProductModal" :product="selectedProduct" @close="handleCloseModal" @add-to-cart="handleAddToCart" />

        <!-- Cart Components -->
        <CartButton @click="handleCartButtonClick" />
        <CartDrawer :show="cart.isOpen" @update:show="handleCartDrawerClose" @checkout="handleCheckout" />
    </navbar-layout>
</template>
