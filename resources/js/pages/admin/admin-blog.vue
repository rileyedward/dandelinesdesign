<script setup lang="ts">
import BlogPostBanner from '@/components/blog/blog-post-banner.vue';
import AdminLayout from '@/layouts/admin-layout.vue';
import { BlogPost } from '@/types/models/blog-post';
import { BlogAdminPageProps as Props } from '@/types/pages/blog';
import { router } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

defineProps<Props>();

const navigateToCreate = () => {
    router.visit('/admin/blog/create');
};

const navigateToEdit = (blogPost: BlogPost) => {
    router.visit(`/admin/blog/edit/${blogPost.id}`);
};
</script>

<template>
    <admin-layout page-title="Blog" page-description="Manage your blog posts and content">
        <div class="container mx-auto">
            <div class="mb-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold">
                        All Posts
                        <span class="ml-2 rounded-full bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-800">{{ blogPosts.length }}</span>
                    </h2>
                    <button
                        @click="navigateToCreate"
                        class="rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                        title="Add Blog Post"
                    >
                        <Plus class="h-5 w-5" />
                    </button>
                </div>

                <div v-if="blogPosts.length === 0" class="rounded-lg bg-gray-50 p-6 text-center">
                    <p class="text-gray-600">No blog posts found</p>
                </div>
                <div v-else class="space-y-4">
                    <blog-post-banner v-for="post in blogPosts" :key="post.id" :blog-post="post" @edit="navigateToEdit" />
                </div>
            </div>
        </div>
    </admin-layout>
</template>
