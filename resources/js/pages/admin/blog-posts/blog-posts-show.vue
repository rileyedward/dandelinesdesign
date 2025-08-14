<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiCheckbox from '@/components/ui/forms/checkbox/ui-checkbox.vue';
import UiImageSelect from '@/components/ui/forms/image-select/ui-image-select.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiRichTextEditor from '@/components/ui/forms/rich-text-editor/ui-rich-text-editor.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { BlogPost } from '@/types/blog';
import { Head, useForm } from '@inertiajs/vue3';
import { Calendar, Edit, Eye, FileText, Save, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    blogPost: BlogPost;
}>();

const isEditing = ref(false);

const form = useForm({
    title: props.blogPost.title,
    slug: props.blogPost.slug,
    content: props.blogPost.content,
    image_url: props.blogPost.image_url || '',
    is_published: props.blogPost.is_published,
});

const generateSlug = (title: string) => {
    return title
        .toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
};

const originalSlug = ref(props.blogPost.slug);

const handleTitleChange = (value: string) => {
    form.title = value;
    if (form.slug === originalSlug.value || form.slug === generateSlug(form.title)) {
        form.slug = generateSlug(value);
    }
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const toggleEdit = () => {
    isEditing.value = !isEditing.value;
};

const handleSubmit = () => {
    form.patch(route('admin.blog.update', props.blogPost.id), {
        onSuccess: () => {
            isEditing.value = false;
        },
    });
};

const handleDelete = () => {
    if (confirm('Are you sure you want to delete this blog post? This action cannot be undone.')) {
        form.delete(route('admin.blog.destroy', props.blogPost.id));
    }
};
</script>

<template>
    <Head :title="blogPost.title" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header
                :title="isEditing ? `Edit: ${blogPost.title}` : blogPost.title"
                :subtitle="isEditing ? 'Update blog post content and settings' : 'Blog post preview'"
                :icon="FileText"
                variant="primary"
            >
                <template #actions>
                    <div class="flex space-x-2">
                        <ui-button v-if="!isEditing" label="Edit Post" variant="primary" size="sm" :prefix-icon="Edit" @click="toggleEdit" />
                        <ui-button v-if="isEditing" label="Delete" variant="destructive" size="sm" :prefix-icon="Trash2" @click="handleDelete" />
                        <ui-button v-if="isEditing" label="View Post" variant="secondary" size="sm" :prefix-icon="Eye" @click="toggleEdit" />
                    </div>
                </template>
            </common-page-header>

            <!-- Edit Form -->
            <div v-if="isEditing" class="rounded-lg border bg-white p-6 shadow-sm">
                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <!-- Title -->
                    <div>
                        <ui-input
                            v-model="form.title"
                            label="Title"
                            placeholder="Enter blog post title"
                            :error="form.errors.title"
                            required
                            @input="handleTitleChange"
                        />
                    </div>

                    <!-- Slug -->
                    <div>
                        <ui-input
                            v-model="form.slug"
                            label="Slug"
                            placeholder="auto-generated-from-title"
                            :error="form.errors.slug"
                            help="URL-friendly version of the title"
                        />
                    </div>

                    <!-- Image -->
                    <div>
                        <ui-image-select
                            v-model="form.image_url"
                            label="Image"
                            placeholder="Select a featured image for this post"
                            :error="form.errors.image_url"
                            help="Choose an image to represent this blog post"
                        />
                    </div>

                    <!-- Content -->
                    <div>
                        <ui-rich-text-editor
                            v-model="form.content"
                            label="Content"
                            placeholder="Write your blog post content here..."
                            :error="form.errors.content"
                            :height="500"
                            required
                            help="Use the rich text editor to format your content with headings, lists, links, and more."
                        />
                    </div>

                    <!-- Published Status -->
                    <div>
                        <ui-checkbox v-model="form.is_published" label="Published" help="Toggle to publish or unpublish this post" />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <ui-button
                            type="submit"
                            label="Update Post"
                            variant="primary"
                            :prefix-icon="Save"
                            :loading="form.processing"
                            :disabled="!form.title || !form.content"
                        />
                    </div>
                </form>
            </div>

            <!-- Preview Mode - Customer-facing style (Default View) -->
            <div v-else class="rounded-lg border bg-gray-50 p-6 shadow-sm">
                <div class="mx-auto max-w-4xl">
                    <!-- Article Header -->
                    <header class="mb-8 text-center">
                        <div class="mb-4">
                            <div class="mb-4 inline-flex items-center text-sm text-gray-500">
                                <Calendar class="mr-2 h-4 w-4" />
                                {{ formatDate(blogPost.created_at) }}
                            </div>
                            <h1 class="text-4xl leading-tight font-bold text-gray-900 md:text-5xl">
                                {{ blogPost.title }}
                            </h1>
                        </div>
                        <div class="mb-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                                <span :class="blogPost.is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                                    {{ blogPost.is_published ? 'Published' : 'Draft' }}
                                </span>
                            </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Slug: <code class="rounded bg-gray-100 px-1 text-xs">{{ blogPost.slug }}</code>
                        </div>
                    </header>

                    <!-- Article Content -->
                    <div class="rounded-2xl bg-white p-8 shadow-lg md:p-12">
                        <div class="prose prose-lg prose-blue max-w-none">
                            <div v-html="blogPost.content"></div>
                        </div>
                    </div>

                    <!-- Article Footer -->
                    <footer class="mt-12 text-center">
                        <div class="mx-auto inline-flex w-full max-w-md items-center justify-center border-t border-gray-200 py-6">
                            <div class="text-sm text-gray-500">
                                Published on {{ formatDate(blogPost.created_at) }}
                                <span v-if="blogPost.updated_at !== blogPost.created_at"> • Updated {{ formatDate(blogPost.updated_at) }} </span>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </sidebar-layout>
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
