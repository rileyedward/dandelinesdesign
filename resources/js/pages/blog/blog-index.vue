<script setup lang="ts">
import BlogGrid from '@/components/blog/blog-grid/blog-grid.vue';
import BlogSplash from '@/components/blog/blog-splash.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import type { BlogPost } from '@/types/blog';
import { Head } from '@inertiajs/vue3';

defineProps<{
    blogPosts: BlogPost[];
}>();
</script>

<template>
    <Head title="Blog - Dandelines Design" />

    <navbar-layout>
        <!-- Hero Section -->
        <blog-splash />

        <!-- Blog Posts Section -->
        <section class="bg-gray-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="mb-12 text-center">
                    <h2 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl">Latest Blog Posts</h2>
                    <p class="mx-auto max-w-2xl text-lg text-gray-600">
                        Discover our latest insights, creative ideas, and inspiration for your next event or floral design project.
                    </p>
                </div>

                <!-- Blog Grid -->
                <blog-grid :blog-posts="blogPosts" />
            </div>
        </section>
    </navbar-layout>
</template>
