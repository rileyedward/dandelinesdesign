<script setup lang="ts">
import ProductBanner from '@/components/product/product-banner/product-banner.vue';
import type { Product } from '@/types/product';
import { Grid } from 'lucide-vue-next';
import type { ProductListEmits, ProductListProps as Props } from './product-list';

withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No products found',
    loadingText: 'Loading products...',
});

const emit = defineEmits<ProductListEmits>();

const handleViewProduct = (product: Product) => {
    emit('view', product);
};
</script>

<template>
    <div class="space-y-4">
        <!-- Header with product count -->
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600"> {{ products.length }} {{ products.length === 1 ? 'product' : 'products' }} </span>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <!-- Loading State -->
            <template v-if="loading">
                <div v-for="i in 8" :key="i" class="aspect-square animate-pulse rounded-lg bg-gray-200" />
                <div class="col-span-full text-center text-sm text-gray-500">
                    {{ loadingText }}
                </div>
            </template>

            <!-- Products -->
            <template v-else-if="products.length > 0">
                <ProductBanner v-for="product in products" :key="product.id" :product="product" @view="handleViewProduct" />
            </template>

            <!-- Empty State -->
            <div v-else class="col-span-full flex flex-col items-center justify-center py-12 text-center">
                <div class="text-gray-400">
                    <Grid class="mx-auto mb-4 h-12 w-12" />
                    <p class="text-lg font-medium text-gray-900">{{ noDataText }}</p>
                    <p class="text-sm text-gray-500">Products are synced from Stripe catalog.</p>
                </div>
            </div>
        </div>
    </div>
</template>
