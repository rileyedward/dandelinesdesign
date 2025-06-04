<script setup lang="ts">
import { BlogPost } from '@/types/models/blog-post';
import { computed } from 'vue';

const props = defineProps<{
    blogPost: BlogPost;
}>();

const formattedDate = computed(() => {
    const date = props.blogPost.published_at ? new Date(props.blogPost.published_at) : new Date(props.blogPost.created_at);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
});
</script>

<template>
    <article class="blog-post">
        <div class="mb-8 text-center">
            <h1 class="mb-4 text-4xl font-bold text-gray-800">{{ blogPost.title }}</h1>
            <p class="text-gray-500">{{ formattedDate }}</p>
            <div class="bg-primary mx-auto mt-6 h-1 w-24 rounded-full"></div>
        </div>

        <div class="blog-content prose prose-lg mx-auto max-w-none after:clear-both after:content-[''] after:table after:block">
            <img
                v-if="blogPost.image_url"
                :src="blogPost.image_url"
                :alt="blogPost.title"
                class="float-right ml-6 mb-4 h-auto w-full rounded-lg object-cover shadow-md md:w-1/3"
            />
            <div v-html="blogPost.content" />
        </div>
    </article>
</template>
