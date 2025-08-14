<script setup lang="ts">
import BlogSplash from '@/components/blog/blog-splash.vue';
import BlogGrid from '@/components/blog/blog-grid/blog-grid.vue';
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
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Latest Blog Posts
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Discover our latest insights, creative ideas, and inspiration for your next event or floral design project.
                    </p>
                </div>
                
                <!-- Blog Grid -->
                <blog-grid :blog-posts="blogPosts" />
            </div>
        </section>
    </navbar-layout>
</template>
