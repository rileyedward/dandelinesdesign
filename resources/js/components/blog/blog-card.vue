<script setup lang="ts">
import { BlogPost } from '@/types/models/blog-post';
import { computed } from 'vue';

const props = defineProps<{
    post: BlogPost;
}>();

const formattedDate = computed(() => {
    const date = props.post.published_at ? new Date(props.post.published_at) : new Date(props.post.created_at);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
});
</script>

<template>
    <div class="blog-card overflow-hidden rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
        <a :href="`/blog/${post.slug}`" class="block">
            <div class="relative h-48 w-full overflow-hidden">
                <img
                    v-if="post.image_url"
                    :src="post.image_url"
                    :alt="post.title"
                    class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
                />
                <div v-else class="flex h-full w-full items-center justify-center bg-gray-200">
                    <span class="text-gray-400">No image available</span>
                </div>
            </div>

            <div class="p-5">
                <p class="mb-2 text-sm text-gray-500">{{ formattedDate }}</p>
                <h3 class="mb-3 line-clamp-2 text-xl font-semibold text-gray-800">{{ post.title }}</h3>
                <p v-if="post.excerpt" class="line-clamp-3 text-gray-600">{{ post.excerpt }}</p>
                <p v-else class="line-clamp-3 text-gray-600">{{ post.content.replace(/<[^>]*>/g, '').substring(0, 150) }}...</p>

                <div class="mt-4">
                    <span class="text-primary inline-block text-sm font-medium hover:underline">Read More</span>
                </div>
            </div>
        </a>
    </div>
</template>

<style scoped>
.blog-card {
    background-color: white;
    height: 100%;
    width: 100%;
    display: flex;
    flex-direction: column;
}

.blog-card a {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
