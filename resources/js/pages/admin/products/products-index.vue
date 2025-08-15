<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import ProductList from '@/components/product/product-list/product-list.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import UiTab from '@/components/ui/navigation/tab/ui-tab.vue';
import type { TabItem } from '@/components/ui/navigation/tab/ui-tab';
import type { Product, Category } from '@/types/product';
import { Head } from '@inertiajs/vue3';
import { Package, Grid, Tag } from 'lucide-vue-next';
import { ref, computed } from 'vue';

interface Props {
    products: Product[];
    categories: Category[];
}

const props = defineProps<Props>();

const activeTab = ref('all');

// Create tabs for all categories plus an "All" tab
const tabs = computed((): TabItem[] => {
    const allTab: TabItem = {
        label: `All (${props.products.length})`,
        value: 'all',
        icon: Grid
    };

    const categoryTabs: TabItem[] = props.categories.map(category => ({
        label: `${category.name} (${props.products.filter(product => product.category_id === category.id).length})`,
        value: category.id.toString(),
        icon: Tag
    }));

    return [allTab, ...categoryTabs];
});

// Filter products based on active tab
const filteredProducts = computed(() => {
    if (activeTab.value === 'all') {
        return props.products;
    }

    const categoryId = parseInt(activeTab.value);
    return props.products.filter(product => product.category_id === categoryId);
});
</script>

<template>
    <Head title="Products" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Products" subtitle="Manage your products" :icon="Package" variant="info" />

            <!-- Category Tabs -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Filter by Category</h2>
                    <span class="text-sm text-gray-500">
                        {{ filteredProducts.length }} {{ filteredProducts.length === 1 ? 'product' : 'products' }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <UiTab
                        v-model="activeTab"
                        :items="tabs"
                        variant="underline"
                        class="min-w-max"
                    />
                </div>
            </div>

            <!-- Products List -->
            <product-list :products="filteredProducts" />
        </div>
    </sidebar-layout>
</template>
