<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import ProductInfo from '@/components/product/product-info/product-info.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { Product } from '@/types/product';
import { Head, router } from '@inertiajs/vue3';
import { ArrowLeft, Package } from 'lucide-vue-next';

interface Props {
    product: Product;
}

defineProps<Props>();

const goBack = () => {
    router.visit('/admin/products');
};
</script>

<template>
    <Head :title="`Product: ${product.name}`" />

    <sidebar-layout>
        <div class="space-y-6">
            <!-- Header with back button -->
            <div class="flex items-center space-x-4">
                <common-page-header :title="product.name" :subtitle="`Product ID: ${product.id}`" :icon="Package" variant="info" class="flex-1" />
            </div>

            <button
                @click="goBack"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
            >
                <ArrowLeft class="mr-2 h-4 w-4" />
                Back to Products
            </button>

            <!-- Product Information -->
            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <ProductInfo :product="product" />
            </div>
        </div>
    </sidebar-layout>
</template>
