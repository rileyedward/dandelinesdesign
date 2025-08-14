<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ArrowLeft, Calendar } from 'lucide-vue-next';
import type { BlogContentProps as Props } from './blog-content';

defineProps<Props>();

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const handleBackToBlog = () => {
    router.visit(route('blog'));
};
</script>

<template>
    <article class="mx-auto max-w-4xl">
        <!-- Back Button -->
        <div class="mb-8">
            <button
                @click="handleBackToBlog"
                class="inline-flex items-center text-sm font-medium text-gray-600 transition-colors duration-200 hover:text-blue-600"
            >
                <ArrowLeft class="mr-2 h-4 w-4" />
                Back to Blog
            </button>
        </div>

        <!-- Article Header -->
        <header class="mb-8 text-center">
            <div class="mb-4">
                <div class="mb-4 inline-flex items-center text-sm text-gray-500">
                    <Calendar class="mr-2 h-4 w-4" />
                    {{ formatDate(post.created_at) }}
                </div>
                <h1 class="text-4xl leading-tight font-bold text-gray-900 md:text-5xl">
                    {{ post.title }}
                </h1>
            </div>
        </header>

        <!-- Article Content -->
        <div class="rounded-2xl bg-white p-8 shadow-lg md:p-12">
            <div class="prose prose-lg prose-blue max-w-none">
                <div v-html="post.content"></div>
            </div>
        </div>

        <!-- Article Footer -->
        <footer class="mt-12 text-center">
            <div class="mx-auto inline-flex w-full max-w-md items-center justify-center border-t border-gray-200 py-6">
                <div class="text-sm text-gray-500">
                    Published on {{ formatDate(post.created_at) }}
                    <span v-if="post.updated_at !== post.created_at"> • Updated {{ formatDate(post.updated_at) }} </span>
                </div>
            </div>

            <!-- Back to Blog Button -->
            <div class="mt-6">
                <button
                    @click="handleBackToBlog"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-3 font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    <ArrowLeft class="mr-2 h-4 w-4" />
                    Back to All Posts
                </button>
            </div>
        </footer>
    </article>
</template>

<style scoped>
/* Custom prose styles for better blog content rendering */
:deep(.prose) {
    color: #374151;
    line-height: 1.75;
}

:deep(.prose h1) {
    color: #111827;
    font-weight: 800;
    font-size: 2.25rem;
    margin-top: 0;
    margin-bottom: 2rem;
    line-height: 1.1;
}

:deep(.prose h2) {
    color: #111827;
    font-weight: 700;
    font-size: 1.875rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
    line-height: 1.3;
}

:deep(.prose h3) {
    color: #111827;
    font-weight: 600;
    font-size: 1.5rem;
    margin-top: 1.6rem;
    margin-bottom: 0.6rem;
    line-height: 1.4;
}

:deep(.prose p) {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
}

:deep(.prose a) {
    color: #2563eb;
    text-decoration: underline;
    font-weight: 500;
}

:deep(.prose a:hover) {
    color: #1d4ed8;
}

:deep(.prose strong) {
    color: #111827;
    font-weight: 600;
}

:deep(.prose ul) {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
    padding-left: 1.625rem;
}

:deep(.prose ol) {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
    padding-left: 1.625rem;
}

:deep(.prose li) {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
}

:deep(.prose blockquote) {
    font-weight: 500;
    font-style: italic;
    color: #374151;
    border-left-width: 0.25rem;
    border-left-color: #d1d5db;
    quotes: '\201C' '\201D' '\2018' '\2019';
    margin-top: 1.6rem;
    margin-bottom: 1.6rem;
    padding-left: 1rem;
}
</style>
