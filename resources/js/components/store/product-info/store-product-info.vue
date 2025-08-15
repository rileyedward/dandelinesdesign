<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import { type Product } from '@/types/product';
import { ImageIcon, MinusIcon, PlusIcon, ShoppingCartIcon, StarIcon, TruckIcon } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Props {
    product: Product;
}

interface Emits {
    'add-to-cart': [product: Product, quantity: number];
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const quantity = ref(1);

const selectedPrice = computed(() => {
    // First try to find the current price
    const currentPrice = props.product.prices?.find((price) => price.is_current);
    if (currentPrice) return currentPrice;

    // Fall back to the first price if no current price is set
    return props.product.prices?.[0] || null;
});

const totalPrice = computed(() => {
    if (!selectedPrice.value) return 0;
    return selectedPrice.value.unit_amount * quantity.value;
});

const maxQuantity = computed(() => {
    return props.product.stock_quantity || 1;
});

const isOutOfStock = computed(() => {
    return props.product.stock_quantity === 0;
});

const showQuantitySelector = computed(() => {
    return props.product.stock_quantity > 1;
});

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(amount);
};

const increaseQuantity = () => {
    if (quantity.value < maxQuantity.value) {
        quantity.value++;
    }
};

const decreaseQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const handleAddToCart = () => {
    emit('add-to-cart', props.product, quantity.value);
};
</script>

<template>
    <div class="bg-white">
        <div class="space-y-8 p-6">
            <!-- Product Images and Basic Info -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Images Section -->
                <div class="space-y-4">
                    <div class="aspect-square w-full overflow-hidden rounded-xl bg-gray-100">
                        <img
                            v-if="product.images?.length ? product.images[0] : product.image_url"
                            :src="product.images?.length ? product.images[0] : product.image_url"
                            :alt="product.name"
                            class="h-full w-full object-cover object-center"
                        />
                        <div v-else class="flex h-full w-full items-center justify-center bg-gray-100 text-gray-400">
                            <ImageIcon class="h-16 w-16" />
                        </div>
                    </div>

                    <!-- Additional Images -->
                    <div v-if="product.images && product.images.length > 1" class="grid grid-cols-4 gap-2">
                        <div
                            v-for="(image, index) in product.images.slice(1, 5)"
                            :key="index"
                            class="aspect-square overflow-hidden rounded-lg bg-gray-100"
                        >
                            <img :src="image" :alt="`${product.name} - Image ${index + 2}`" class="h-full w-full object-cover object-center" />
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="space-y-6">
                    <!-- Title and Badges -->
                    <div>
                        <h1 class="mb-2 text-3xl font-bold text-gray-900">{{ product.name }}</h1>
                        <div class="mb-4 flex flex-wrap gap-2">
                            <span
                                v-if="product.is_featured"
                                class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800"
                            >
                                <StarIcon class="mr-1 h-4 w-4" />
                                Featured
                            </span>
                            <span
                                v-if="!product.shippable"
                                class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800"
                            >
                                Digital Product
                            </span>
                            <span
                                v-if="isOutOfStock"
                                class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800"
                            >
                                Out of Stock
                            </span>
                            <span
                                v-else-if="product.stock_quantity <= 2"
                                class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-sm font-medium text-amber-800"
                            >
                                Only {{ product.stock_quantity }} left
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div v-if="product.description" class="prose prose-sm max-w-none">
                        <p class="leading-relaxed text-gray-600">{{ product.description }}</p>
                    </div>

                    <!-- Price Display -->
                    <div v-if="selectedPrice" class="space-y-4">
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-gray-900">
                                    {{ formatCurrency(selectedPrice.unit_amount) }}
                                </div>
                                <div v-if="selectedPrice.nickname" class="mt-1 text-sm text-gray-600">
                                    {{ selectedPrice.nickname }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity Selector -->
                    <div v-if="showQuantitySelector && !isOutOfStock" class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Quantity</h3>
                        <div class="flex items-center space-x-3">
                            <button
                                @click="decreaseQuantity"
                                :disabled="quantity <= 1"
                                class="rounded-lg border border-gray-300 p-2 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <MinusIcon class="h-4 w-4" />
                            </button>
                            <span class="w-12 text-center text-xl font-medium">{{ quantity }}</span>
                            <button
                                @click="increaseQuantity"
                                :disabled="quantity >= maxQuantity"
                                class="rounded-lg border border-gray-300 p-2 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <PlusIcon class="h-4 w-4" />
                            </button>
                        </div>
                        <p class="text-sm text-gray-500">Maximum {{ maxQuantity }} available</p>
                    </div>

                    <!-- Single Item Message -->
                    <div v-else-if="!isOutOfStock && product.stock_quantity === 1" class="space-y-4">
                        <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                            <p class="text-sm font-medium text-blue-800">Limited Edition - Only 1 available</p>
                        </div>
                    </div>

                    <!-- Total Price -->
                    <div v-if="selectedPrice" class="rounded-lg bg-gray-50 p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-medium text-gray-900">Total:</span>
                            <span class="text-primary-600 text-2xl font-bold">
                                {{ formatCurrency(totalPrice) }}
                            </span>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <UiButton
                        @click="handleAddToCart"
                        :disabled="!selectedPrice || isOutOfStock"
                        variant="primary"
                        size="lg"
                        class="w-full"
                        :icon="ShoppingCartIcon"
                    >
                        {{ isOutOfStock ? 'Out of Stock' : 'Add to Cart' }}
                    </UiButton>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.prose {
    max-width: none;
}
</style>
