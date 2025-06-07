<script setup lang="ts">
import ProductBanner from '@/components/product/product-banner.vue';
import AdminLayout from '@/layouts/admin-layout.vue';
import { Product } from '@/types/models/product';
import { ProductAdminPageProps as Props } from '@/types/pages/product';
import { router } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

defineProps<Props>();

const navigateToCreate = () => {
    router.visit('/admin/products/create');
};

const navigateToEdit = (product: Product) => {
    router.visit(`/admin/products/edit/${product.id}`);
};

const deleteProduct = (id: number) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(`/admin/products/${id}`);
    }
};
</script>

<template>
    <admin-layout page-title="Products" page-description="Manage your store products and inventory">
        <div class="container mx-auto">
            <div class="mb-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold">
                        All Products
                        <span class="ml-2 rounded-full bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-800">{{ products.length }}</span>
                    </h2>
                    <button
                        @click="navigateToCreate"
                        class="rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                        title="Add Product"
                    >
                        <Plus class="h-5 w-5" />
                    </button>
                </div>

                <div v-if="products.length === 0" class="rounded-lg bg-gray-50 p-6 text-center">
                    <p class="text-gray-600">No products found</p>
                </div>
                <div v-else class="space-y-4">
                    <product-banner v-for="product in products" :key="product.id" :product="product" @edit="navigateToEdit" @delete="deleteProduct" />
                </div>
            </div>
        </div>
    </admin-layout>
</template>
