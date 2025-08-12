<script setup lang="ts">
import ProductList from '@/components/product/product-list/product-list.vue';
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { Product } from '@/types/product';
import { Head } from '@inertiajs/vue3';
import { Package } from 'lucide-vue-next';

defineProps<{
    products: Product[];
}>();
</script>

<template>
    <Head title="Products" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Products" subtitle="Manage your products" :icon="Package" variant="info" />

            <product-list :products="products" />
        </div>
    </sidebar-layout>
</template>
