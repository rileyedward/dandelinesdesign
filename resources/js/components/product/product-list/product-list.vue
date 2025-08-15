<script setup lang="ts">
import ProductBanner from '@/components/product/product-banner/product-banner.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import type { Product } from '@/types/product';
import { Grid, Plus } from 'lucide-vue-next';
import type { ProductListProps as Props, ProductListEmits } from './product-list';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No products found',
    loadingText: 'Loading products...',
});

const emit = defineEmits<ProductListEmits>();

const handleViewProduct = (product: Product) => {
    emit('view', product);
};

const handleEditProduct = (product: Product) => {
    emit('edit', product);
};

const handleCreateProduct = () => {
    emit('create');
};
</script>

<template>
  <div class="space-y-4">
    <!-- Header with product count and actions -->
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-2">
        <span class="text-sm text-gray-600">
          {{ products.length }} {{ products.length === 1 ? 'product' : 'products' }}
        </span>
      </div>
      
      <UiButton
        variant="default"
        size="sm"
        @click="handleCreateProduct"
      >
        <Plus class="mr-2 h-4 w-4" />
        Add Product
      </UiButton>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <!-- Loading State -->
      <template v-if="loading">
        <div
          v-for="i in 8"
          :key="i"
          class="aspect-square animate-pulse rounded-lg bg-gray-200"
        />
        <div class="text-center text-sm text-gray-500 col-span-full">
          {{ loadingText }}
        </div>
      </template>
      
      <!-- Products -->
      <template v-else-if="products.length > 0">
        <ProductBanner
          v-for="product in products"
          :key="product.id"
          :product="product"
          @view="handleViewProduct"
          @edit="handleEditProduct"
        />
      </template>
      
      <!-- Empty State -->
      <div
        v-else
        class="col-span-full flex flex-col items-center justify-center py-12 text-center"
      >
        <div class="text-gray-400">
          <Grid class="mx-auto h-12 w-12 mb-4" />
          <p class="text-lg font-medium text-gray-900">{{ noDataText }}</p>
          <p class="text-sm text-gray-500">Get started by creating your first product.</p>
        </div>
        <UiButton
          variant="default"
          class="mt-4"
          @click="handleCreateProduct"
        >
          <Plus class="mr-2 h-4 w-4" />
          Add Product
        </UiButton>
      </div>
    </div>
  </div>
</template>