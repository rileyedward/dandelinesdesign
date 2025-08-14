<script setup lang="ts">
import BlogCard from '@/components/blog/blog-card/blog-card.vue';
import type { BlogGridProps as Props } from './blog-grid';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No blog posts available at the moment.',
    loadingText: 'Loading blog posts...',
});
</script>

<template>
    <div class="space-y-8">
        <!-- Loading State -->
        <div v-if="loading" class="py-16 text-center">
            <div class="inline-flex items-center px-6 py-3 rounded-full bg-blue-50 text-blue-600">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ loadingText }}
            </div>
        </div>

        <!-- No Data State -->
        <div v-else-if="blogPosts.length === 0" class="py-16 text-center">
            <div class="mx-auto mb-4 h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center">
                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No blog posts yet</h3>
            <p class="text-gray-600">{{ noDataText }}</p>
        </div>

        <!-- Blog Posts Grid -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <blog-card 
                v-for="post in blogPosts" 
                :key="post.id" 
                :post="post"
            />
        </div>
    </div>
</template>