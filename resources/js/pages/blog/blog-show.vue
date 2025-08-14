<script setup lang="ts">
import BlogContent from '@/components/blog/blog-content/blog-content.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import type { BlogPost } from '@/types/blog';
import { Head } from '@inertiajs/vue3';

defineProps<{
    blogPost: BlogPost;
}>();
</script>

<template>
    <Head :title="`${blogPost.title} - Dandelines Design Blog`" />

    <navbar-layout>
        <!-- Blog Post Content -->
        <section class="min-h-screen bg-gray-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <blog-content :post="blogPost" />
            </div>
        </section>
    </navbar-layout>
</template>
