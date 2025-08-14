<script setup lang="ts">
import BlogContent from '@/components/blog/blog-content/blog-content.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import type { BlogPost } from '@/types/blog';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
    blogPost: BlogPost;
}>();
</script>

<template>
    <Head :title="`${blogPost.title} - Dandelines Design Blog`" />
    
    <navbar-layout>
        <!-- Blog Post Content -->
        <section class="py-16 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <blog-content :post="blogPost" />
            </div>
        </section>
    </navbar-layout>
</template>