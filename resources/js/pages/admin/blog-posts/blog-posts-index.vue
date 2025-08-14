<script setup lang="ts">
import BlogList from '@/components/blog/blog-list/blog-list.vue';
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { BlogPost } from '@/types/blog';
import { Head } from '@inertiajs/vue3';
import { FileText, Plus } from 'lucide-vue-next';

defineProps<{
    blogPosts: BlogPost[];
}>();

const handleCreateBlogPost = () => {
    window.location.href = route('admin.blog.create');
};
</script>

<template>
    <Head title="Blog Posts" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Blog Posts" subtitle="Manage your blog content" :icon="FileText" variant="primary">
                <template #actions>
                    <ui-button label="New" variant="primary" size="sm" :prefix-icon="Plus" @click="handleCreateBlogPost" />
                </template>
            </common-page-header>

            <blog-list :blog-posts="blogPosts" />
        </div>
    </sidebar-layout>
</template>
