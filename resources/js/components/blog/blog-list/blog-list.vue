<script setup lang="ts">
import BlogBanner from '@/components/blog/blog-banner/blog-banner.vue';
import type { BlogPost } from '@/types/blog';
import type { BlogListProps as Props } from './blog-list';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No blog posts found',
    loadingText: 'Loading blog posts...',
});
</script>

<template>
    <div class="space-y-6">
        <div v-if="loading" class="py-8 text-center text-gray-500">
            {{ loadingText }}
        </div>

        <div v-else-if="blogPosts.length === 0" class="py-8 text-center text-gray-500">
            {{ noDataText }}
        </div>

        <div v-else class="grid grid-cols-1 gap-6">
            <blog-banner 
                v-for="post in blogPosts" 
                :key="post.id" 
                :post="post" 
                :show-status="true"
            />
        </div>
    </div>
</template>
