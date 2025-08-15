<script setup lang="ts">
import StoreProductBanner from '@/components/store/product-banner/store-product-banner.vue';
import type { Product } from '@/types/product';
import { Grid } from 'lucide-vue-next';
import type { StoreProductListProps as Props, StoreProductListEmits } from './store-product-list';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No products available',
    loadingText: 'Loading products...',
});

const emit = defineEmits<StoreProductListEmits>();

const handleViewProduct = (product: Product) => {
    emit('view', product);
};
</script>

<template>
    <div class="space-y-6">
        <!-- Header with product count -->
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600"> {{ products.length }} {{ products.length === 1 ? 'product' : 'products' }} available </span>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <!-- Loading State -->
            <template v-if="loading">
                <div v-for="i in 8" :key="i" class="aspect-square animate-pulse rounded-xl bg-gray-200" />
                <div class="col-span-full text-center text-sm text-gray-500">
                    {{ loadingText }}
                </div>
            </template>

            <!-- Products -->
            <template v-else-if="products.length > 0">
                <StoreProductBanner v-for="product in products" :key="product.id" :product="product" @view="handleViewProduct" />
            </template>

            <!-- Empty State -->
            <div v-else class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                <div class="text-gray-400">
                    <Grid class="mx-auto mb-4 h-16 w-16" />
                    <p class="text-xl font-medium text-gray-900">{{ noDataText }}</p>
                    <p class="mt-2 text-sm text-gray-500">Check back soon for new products!</p>
                </div>
            </div>
        </div>
    </div>
</template>
