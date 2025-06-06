<script setup lang="ts">
import { ProductCardProps as Props } from '@/types/components/product-card';
import { computed } from 'vue';

const props = defineProps<Props>();

const formattedPrice = computed(() => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(props.product.price);
});
</script>

<template>
    <div class="product-card relative overflow-hidden rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
        <div class="relative h-64 w-full overflow-hidden">
            <img
                v-if="product.image_url"
                :src="product.image_url"
                :alt="product.name"
                class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
            />
            <div v-else class="flex h-full w-full items-center justify-center bg-gray-200">
                <span class="text-gray-400">No image available</span>
            </div>

            <!-- Hover overlay with product info -->
            <div class="product-info absolute inset-0 flex flex-col items-center justify-center bg-zinc-500 bg-opacity-60 p-4 text-white opacity-0 transition-opacity duration-300">
                <h3 class="mb-2 text-center text-xl font-semibold">{{ product.name }}</h3>
                <p class="text-lg font-bold text-primary">{{ formattedPrice }}</p>
                <p v-if="product.description" class="mt-2 line-clamp-3 text-center text-sm">{{ product.description }}</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.product-card {
    background-color: white;
    height: 100%;
    width: 100%;
    cursor: pointer;
}

.product-card:hover .product-info {
    opacity: 1;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.text-primary {
    color: #f59e0b;
}
</style>
