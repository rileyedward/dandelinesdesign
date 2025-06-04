<script setup lang="ts">
import Background from '@/components/background/background.vue';
import BlogCard from '@/components/blog/blog-card.vue';
import BlogWidget from '@/components/blog/blog-widget.vue';
import AppLayout from '@/layouts/app-layout.vue';
import { BlogPost } from '@/types/models/blog-post';

defineProps<{
    posts: BlogPost[];
}>();
</script>

<template>
    <app-layout>
        <background imageUrl="/images/blog-background.jpg">
            <div class="flex h-full items-center justify-center">
                <h1 class="text-4xl font-bold text-white">Our Blog</h1>
            </div>
            <blog-widget />
        </background>

        <div class="container mx-auto px-4 py-12">
            <div class="mb-10 text-center">
                <h2 class="mb-3 text-3xl font-bold text-gray-800">Latest Articles</h2>
                <p class="mx-auto max-w-2xl text-gray-600">
                    Explore our latest insights, tips, and creative inspirations to help you bring your vision to life.
                </p>
            </div>

            <div v-if="posts.length > 0" class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div v-for="post in posts" :key="post.id" class="flex w-full">
                    <blog-card :post="post" />
                </div>
            </div>

            <div v-else class="my-12 text-center">
                <p class="text-gray-600">No blog posts available at the moment. Check back soon!</p>
            </div>
        </div>
    </app-layout>
</template>
