<script setup lang="ts">
import CategoryList from '@/components/category/category-list/category-list.vue';
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { Category } from '@/types/category';
import { Head } from '@inertiajs/vue3';
import { Tag } from 'lucide-vue-next';

defineProps<{
    categories: Category[];
}>();
</script>

<template>
    <Head title="Categories" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Categories" subtitle="Manage product categories" :icon="Tag" variant="secondary" />

            <category-list :categories="categories" />
        </div>
    </sidebar-layout>
</template>
