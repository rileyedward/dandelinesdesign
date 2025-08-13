<script setup lang="ts">
import CategoryBanner from '@/components/category/category-banner/category-banner.vue';
import CategoryUpdateModal from '@/components/category/category-update-modal/category-update-modal.vue';
import type { Category } from '@/types/category';
import { ref } from 'vue';
import type { CategoryListProps as Props } from './category-list';

defineProps<Props>();

const showUpdateModal = ref(false);
const selectedCategory = ref<Category | null>(null);

const handleCategoryClick = (category: Category) => {
    selectedCategory.value = category;
    showUpdateModal.value = true;
};

const handleCategoryUpdated = () => {
    window.location.reload();
};
</script>

<template>
    <div class="space-y-6">
        <div v-if="loading" class="py-8 text-center text-gray-500">
            {{ loadingText }}
        </div>

        <div v-else-if="categories.length === 0" class="py-8 text-center text-gray-500">
            {{ noDataText }}
        </div>

        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="category in categories"
                :key="category.id"
                class="cursor-pointer transition-all duration-300 hover:scale-105"
                @click="handleCategoryClick(category)"
            >
                <category-banner :category="category" />
            </div>
        </div>

        <category-update-modal v-if="selectedCategory" v-model:show="showUpdateModal" :category="selectedCategory" @updated="handleCategoryUpdated" />
    </div>
</template>
