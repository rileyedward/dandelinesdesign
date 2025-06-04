<script setup lang="ts">
import BlogContent from '@/components/blog/blog-content.vue';
import AppLayout from '@/layouts/app-layout.vue';
import { BlogShowPageProps as Props } from '@/types/pages/blog';

defineProps<Props>();
</script>

<template>
    <app-layout>
        <div class="container mx-auto px-4 py-12">
            <div class="mx-auto max-w-4xl">
                <blog-content :blog-post="blogPost" />
            </div>
        </div>
    </app-layout>
</template>
