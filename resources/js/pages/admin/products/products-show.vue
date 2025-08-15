<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import ProductInfo from '@/components/product/product-info/product-info.vue';
import UiSelect from '@/components/ui/forms/select/ui-select.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { Product, Category } from '@/types/product';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Package, Trash2, Edit3 } from 'lucide-vue-next';
import { watch } from 'vue';

interface Props {
    product: Product;
    categories: Category[];
}

const props = defineProps<Props>();

const goBack = () => {
    router.visit('/admin/products');
};

// Category update form
const categoryForm = useForm({
    category_id: props.product.category_id
});

const updateCategory = () => {
    categoryForm.patch(`/admin/products/${props.product.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            // Success message is handled by flash message from controller
        }
    });
};

// Watch for category changes and auto-submit
watch(() => categoryForm.category_id, (newCategoryId, oldCategoryId) => {
    // Only submit if the value actually changed and it's different from the original product category
    if (newCategoryId !== oldCategoryId && newCategoryId !== props.product.category_id) {
        updateCategory();
    }
});

const deleteProduct = () => {
    router.delete(`/admin/products/${props.product.id}`, {
        onBefore: () => confirm('Are you sure you want to delete this product? This action cannot be undone.'),
        onSuccess: () => {
            router.visit('/admin/products');
        }
    });
};
</script>

<template>
    <Head :title="`Product: ${product.name}`" />

    <sidebar-layout>
        <div class="space-y-6">
            <!-- Header with back button and actions -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <common-page-header :title="product.name" :subtitle="`Product ID: ${product.id}`" :icon="Package" variant="info" class="flex-1" />
                </div>

                <ui-button
                    variant="outline"
                    size="sm"
                    :prefix-icon="Trash2"
                    @click="deleteProduct"
                >
                    Delete Product
                </ui-button>
            </div>

            <button
                @click="goBack"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
            >
                <ArrowLeft class="mr-2 h-4 w-4" />
                Back to Products
            </button>

            <!-- Category Management -->
            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <Edit3 class="mr-2 h-5 w-5" />
                        Product Category
                    </h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Category
                        </label>
                        <UiSelect
                            id="category"
                            v-model="categoryForm.category_id"
                            :options="categories.map(cat => ({ value: cat.id, label: cat.name }))"
                            placeholder="Select a category"
                            :disabled="categoryForm.processing"
                        />
                        <div class="mt-2 flex items-center space-x-2">
                            <p class="text-sm text-gray-500">
                                Only the category can be updated locally. All other product information is managed through Stripe.
                            </p>
                            <div v-if="categoryForm.processing" class="flex items-center text-sm text-blue-600">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Updating...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <ProductInfo :product="product" />
            </div>
        </div>
    </sidebar-layout>
</template>
