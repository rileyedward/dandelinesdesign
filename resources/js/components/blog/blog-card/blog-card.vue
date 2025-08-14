<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ArrowRight, Calendar } from 'lucide-vue-next';
import type { BlogCardProps as Props } from './blog-card';

const props = defineProps<Props>();

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const truncateContent = (content: string, maxLength: number = 120) => {
    // Strip HTML tags for display
    const strippedContent = content.replace(/<[^>]*>/g, '');
    if (strippedContent.length <= maxLength) return strippedContent;
    return strippedContent.substring(0, maxLength) + '...';
};

const handleReadMore = () => {
    router.visit(route('blog.show', props.post.slug));
};
</script>

<template>
    <article
        class="group cursor-pointer rounded-2xl border border-gray-200 bg-white p-6 shadow-lg transition-all duration-300 hover:border-blue-300 hover:shadow-xl"
        @click="handleReadMore"
    >
        <!-- Header -->
        <div class="mb-4">
            <div class="mb-3 flex items-center text-sm text-gray-500">
                <Calendar class="mr-2 h-4 w-4" />
                {{ formatDate(post.created_at) }}
            </div>
            <h2 class="text-xl font-bold text-gray-900 transition-colors duration-200 group-hover:text-blue-600">
                {{ post.title }}
            </h2>
        </div>

        <!-- Content Preview -->
        <div class="mb-6">
            <p class="leading-relaxed text-gray-700">
                {{ truncateContent(post.content) }}
            </p>
        </div>

        <!-- Read More -->
        <div class="flex items-center justify-between">
            <div class="text-sm font-medium text-blue-600 transition-colors duration-200 group-hover:text-blue-700">Read more</div>
            <ArrowRight class="h-4 w-4 text-blue-600 transition-all duration-200 group-hover:translate-x-1 group-hover:text-blue-700" />
        </div>
    </article>
</template>
