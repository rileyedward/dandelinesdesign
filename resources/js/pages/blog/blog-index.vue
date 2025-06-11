<script setup lang="ts">
import Background from '@/components/background/background.vue';
import BlogCard from '@/components/blog/blog-card.vue';
import BlogWidget from '@/components/blog/blog-widget.vue';
import AppLayout from '@/layouts/app-layout.vue';
import { BlogIndexPageProps as Props } from '@/types/pages/blog';

defineProps<Props>();
</script>

<template>
    <app-layout>
        <background imageUrl="/images/background/blog-bg.jpg">
            <blog-widget />
        </background>

        <div class="container mx-auto px-4 py-12">
            <div class="mb-12 text-center">
                <h2 class="mb-4 text-4xl font-bold text-gray-800">Journal & Inspirations</h2>
                <div class="mx-auto max-w-lg">
                    <p class="leading-relaxed text-gray-600">
                        Discover floral artistry, event design insights, and creative inspiration from our team of passionate designers.
                    </p>
                </div>
                <div class="bg-primary mx-auto mt-6 h-1 w-24 rounded-full"></div>
            </div>

            <div v-if="blogPosts.length > 0" class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div v-for="post in blogPosts" :key="post.id" class="flex w-full">
                    <blog-card :post="post" />
                </div>
            </div>

            <div v-else class="my-12 text-center">
                <p class="text-gray-600">No blog posts available at the moment. Check again soon!</p>
            </div>
        </div>
    </app-layout>
</template>
