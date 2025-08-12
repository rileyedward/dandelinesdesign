<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { BlogPost } from '@/types/blog';
import { Head } from '@inertiajs/vue3';
import { Calendar, Eye, FileText } from 'lucide-vue-next';

defineProps<{
    blogPost: BlogPost;
}>();
</script>

<template>
    <Head :title="blogPost.title" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header :title="blogPost.title" subtitle="Blog post details" :icon="FileText" variant="primary" />

            <!-- Blog Post Content -->
            <div class="rounded-lg border bg-white p-6 shadow-sm">
                <div class="space-y-6">
                    <!-- Meta Information -->
                    <div class="flex items-center space-x-6 border-b pb-4 text-sm text-gray-500">
                        <div class="flex items-center">
                            <Calendar class="mr-1 h-4 w-4" />
                            Created: {{ new Date(blogPost.created_at).toLocaleDateString() }}
                        </div>
                        <div class="flex items-center">
                            <Eye class="mr-1 h-4 w-4" />
                            Status:
                            <span :class="blogPost.is_published ? 'ml-1 text-green-600' : 'ml-1 text-yellow-600'">
                                {{ blogPost.is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Slug</label>
                        <code class="rounded bg-gray-100 px-2 py-1 text-sm">{{ blogPost.slug }}</code>
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Content</label>
                        <div class="prose max-w-none rounded-lg bg-gray-50 p-4">
                            {{ blogPost.content }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </sidebar-layout>
</template>
