<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import { type Product } from '@/types/product';
import { EyeIcon, ImageIcon } from 'lucide-vue-next';

interface Props {
    product: Product;
}

interface Emits {
    view: [product: Product];
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const handleViewProduct = () => {
    emit('view', props.product);
};

const getCurrentPrice = () => {
    if (!props.product.prices?.length) return null;

    // First try to find the current price
    const currentPrice = props.product.prices.find(price => price.is_current);
    if (currentPrice) return currentPrice.unit_amount;

    // Fall back to the lowest price if no current price is set
    return Math.min(...props.product.prices.map((price) => price.unit_amount));
};
</script>

<template>
    <div
        class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
    >
        <div class="aspect-square w-full overflow-hidden bg-gray-50">
            <img
                v-if="product.images?.length ? product.images[0] : product.image_url"
                :src="product.images?.length ? product.images[0] : product.image_url"
                :alt="product.name"
                class="h-full w-full cursor-pointer object-cover object-center transition-transform duration-300 group-hover:scale-110"
                @click="handleViewProduct"
            />
            <div v-else class="flex h-full w-full cursor-pointer items-center justify-center bg-gray-50 text-gray-400" @click="handleViewProduct">
                <ImageIcon class="h-16 w-16" />
            </div>
        </div>

        <!-- Product Info -->
        <div class="space-y-3 p-4">
            <!-- Product Name -->
            <h3
                class="hover:text-primary-600 line-clamp-2 cursor-pointer text-lg font-semibold text-gray-900 transition-colors"
                @click="handleViewProduct"
            >
                {{ product.name }}
            </h3>

            <p v-if="product.description" class="line-clamp-2 text-sm text-gray-600">
                {{ product.description }}
            </p>

            <!-- Price and Actions -->
            <div class="flex items-center justify-between pt-2">
                <div class="flex flex-col">
                    <span v-if="getCurrentPrice()" class="text-2xl font-bold text-gray-900"> ${{ getCurrentPrice() }} </span>
                    <span v-else class="text-sm text-gray-500"> Price not available </span>
                    <span v-if="product.prices?.length > 1" class="text-xs text-gray-500"> Multiple options available </span>
                </div>

                <div class="flex space-x-2">
                    <ui-button
                        @click="handleViewProduct"
                        variant="outline"
                        size="sm"
                        :icon="EyeIcon"
                        class="opacity-0 transition-opacity group-hover:opacity-100"
                    >
                        View
                    </ui-button>
                </div>
            </div>
        </div>

        <!-- Multiple Images Indicator -->
        <div v-if="product.images && product.images.length > 1" class="absolute top-3 right-3">
            <div class="inline-flex items-center rounded-full bg-black/70 px-2 py-1 text-xs font-medium text-white">
                <ImageIcon class="mr-1 h-3 w-3" />
                {{ product.images.length }}
            </div>
        </div>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
