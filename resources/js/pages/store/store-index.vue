<script setup lang="ts">
import Background from '@/components/background/background.vue';
import ProductCard from '@/components/store/product-card.vue';
import ProductModal from '@/components/store/product-modal.vue';
import StoreWidget from '@/components/store/store-widget.vue';
import AppLayout from '@/layouts/app-layout.vue';
import { Product } from '@/types/models/product';
import { StoreIndexPageProps as Props } from '@/types/pages/store';
import { ref } from 'vue';

defineProps<Props>();

const selectedProduct = ref<Product | null>(null);
const isModalOpen = ref(false);

const openProductModal = (product: Product) => {
    selectedProduct.value = product;
    isModalOpen.value = true;
};

const closeProductModal = () => {
    isModalOpen.value = false;
};
</script>

<template>
    <app-layout>
        <background imageUrl="/images/background/store-bg.jpeg">
            <store-widget />
        </background>

        <div class="container mx-auto px-4 py-12">
            <div class="mb-12 text-center">
                <h2 class="mb-4 text-4xl font-bold text-gray-800">Our Products</h2>
                <div class="mx-auto max-w-2xl">
                    <p class="leading-relaxed text-gray-600">
                        Discover our handcrafted floral arrangements and unique gifts created with love and attention to detail.
                    </p>
                </div>
                <div class="bg-primary mx-auto mt-6 h-1 w-24 rounded-full" style="background-color: #f59e0b"></div>
            </div>

            <div v-if="products.length > 0" class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <div v-for="product in products" :key="product.id" class="flex w-full">
                    <product-card :product="product" @click="openProductModal" />
                </div>
            </div>

            <div v-else class="my-12 text-center">
                <p class="text-gray-600">No products available at the moment. Check back soon!</p>
            </div>

            <product-modal v-if="selectedProduct" :product="selectedProduct" :is-open="isModalOpen" :on-close="closeProductModal" />
        </div>
    </app-layout>
</template>
