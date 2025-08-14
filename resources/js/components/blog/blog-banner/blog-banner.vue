<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Calendar, FileText } from 'lucide-vue-next';
import type { BlogBannerProps as Props } from './blog-banner';

const { post } = withDefaults(defineProps<Props>(), {
    showStatus: true,
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const getStatusClasses = (isPublished: boolean) => {
    return isPublished ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
};

const getStatusLabel = (isPublished: boolean) => {
    return isPublished ? 'Published' : 'Draft';
};

const truncateContent = (content: string, maxLength: number = 150) => {
    // Strip HTML tags for display
    const strippedContent = content.replace(/<[^>]*>/g, '');
    if (strippedContent.length <= maxLength) return strippedContent;
    return strippedContent.substring(0, maxLength) + '...';
};

const handleClick = () => {
    router.visit(route('admin.blog.show', post.id));
};
</script>

<template>
    <div
        class="cursor-pointer rounded-lg border border-gray-200 bg-white p-6 shadow-md transition-all duration-300 hover:border-blue-300 hover:shadow-lg"
        @click="handleClick"
    >
        <div class="mb-4 flex items-start justify-between">
            <div class="flex-1">
                <h3 class="mb-1 text-lg font-semibold text-gray-900">{{ post.title }}</h3>
                <p class="flex items-center text-sm text-gray-600">
                    <FileText class="mr-1 h-3 w-3" />
                    Slug: <code class="ml-1 rounded bg-gray-100 px-1 text-xs">{{ post.slug }}</code>
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <div v-if="showStatus" :class="['rounded-full px-2 py-1 text-xs', getStatusClasses(post.is_published)]">
                    {{ getStatusLabel(post.is_published) }}
                </div>
            </div>
        </div>

        <div class="mb-4">
            <p class="text-gray-700">{{ truncateContent(post.content) }}</p>
        </div>

        <div class="flex items-center text-sm text-gray-500">
            <Calendar class="mr-1 h-4 w-4" />
            Created {{ formatDate(post.created_at) }}
            <span v-if="post.updated_at !== post.created_at" class="ml-2"> • Updated {{ formatDate(post.updated_at) }} </span>
        </div>
    </div>
</template>
