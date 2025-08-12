<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import BlogList from '@/components/blog/blog-list/blog-list.vue';
import type { BlogPost } from '@/types/blog';
import { FileText } from 'lucide-vue-next';

defineProps<{
    blogPosts: BlogPost[];
}>();
</script>

<template>
    <Head title="Blog Posts" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header
                title="Blog Posts"
                subtitle="Manage your blog content"
                :icon="FileText"
                variant="primary"
            />

            <blog-list :blog-posts="blogPosts" />
        </div>
    </sidebar-layout>
</template>
