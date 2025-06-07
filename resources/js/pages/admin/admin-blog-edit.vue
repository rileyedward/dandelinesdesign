<script setup lang="ts">
import AdminLayout from '@/layouts/admin-layout.vue';
import { BlogPostData } from '@/types/models/blog-post';
import { BlogAdminEditPageProps as Props } from '@/types/pages/blog';
import { router } from '@inertiajs/vue3';
import { Save, Trash2, X } from 'lucide-vue-next';
import { reactive, ref } from 'vue';

const props = defineProps<Props>();

const form = reactive<BlogPostData>({
    title: props.blogPost.title,
    content: props.blogPost.content,
    image_url: props.blogPost.image_url,
    image: null as File | null,
    is_published: props.blogPost.is_published,
});

const errors = reactive<Record<string, string>>({});
const isSubmitting = ref(false);

const submitForm = () => {
    isSubmitting.value = true;

    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('content', form.content);
    if (form.image) {
        formData.append('image', form.image);
    }
    if (form.image_url) {
        formData.append('image_url', form.image_url);
    }
    formData.append('is_published', form.is_published ? '1' : '0');
    formData.append('_method', 'PATCH'); // For method spoofing

    router.post(`/admin/blog/${props.blogPost.id}`, formData, {
        onSuccess: () => {
            router.visit('/admin/blog');
        },
        onError: (err) => {
            Object.assign(errors, err);
            isSubmitting.value = false;
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};

const deleteBlogPost = () => {
    if (confirm('Are you sure you want to delete this blog post? This action cannot be undone.')) {
        router.delete(`/admin/blog/${props.blogPost.id}`, {
            onSuccess: () => {
                router.visit('/admin/blog');
            },
        });
    }
};

const cancelForm = () => {
    router.visit('/admin/blog');
};
</script>

<template>
    <admin-layout page-title="Edit Blog Post" page-description="Update an existing blog post">
        <div class="container mx-auto">
            <form @submit.prevent="submitForm" class="rounded-lg bg-white p-6 shadow-md">
                <div class="mb-6">
                    <label for="title" class="mb-2 block text-sm font-medium text-gray-700">Title *</label>
                    <input
                        id="title"
                        v-model="form.title"
                        type="text"
                        class="block w-full rounded-md border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                    <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
                </div>

                <div class="mb-6">
                    <label for="image" class="mb-2 block text-sm font-medium text-gray-700">Blog Image</label>

                    <!-- Show current image if it exists -->
                    <div v-if="form.image_url" class="mb-3">
                        <img :src="form.image_url" alt="Current blog image" class="mb-2 h-40 w-auto rounded-md object-cover" />
                        <p class="text-sm text-gray-500">Current image</p>
                    </div>

                    <input
                        id="image"
                        type="file"
                        accept="image/*"
                        @change="(e) => (form.image = e.target.files?.[0] || null)"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200"
                    />
                    <p class="mt-1 text-sm text-gray-500">Upload a new blog image (JPEG, PNG, GIF only, max 2MB)</p>
                    <p v-if="errors.image" class="mt-1 text-sm text-red-600">{{ errors.image }}</p>
                </div>

                <div class="mb-6">
                    <label for="content" class="mb-2 block text-sm font-medium text-gray-700">Content *</label>
                    <textarea
                        id="content"
                        v-model="form.content"
                        rows="10"
                        class="block w-full rounded-md border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                        required
                    ></textarea>
                    <p v-if="errors.content" class="mt-1 text-sm text-red-600">{{ errors.content }}</p>
                </div>

                <div class="mb-6">
                    <div class="flex items-center">
                        <input
                            id="is_published"
                            v-model="form.is_published"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        />
                        <label for="is_published" class="ml-2 block text-sm font-medium text-gray-700">Publish?</label>
                    </div>
                    <p v-if="errors.is_published" class="mt-1 text-sm text-red-600">{{ errors.is_published }}</p>
                </div>

                <div class="flex justify-between">
                    <button
                        type="button"
                        @click="deleteBlogPost"
                        class="rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                        title="Delete Blog Post"
                    >
                        <Trash2 class="h-5 w-5" />
                    </button>

                    <div class="flex space-x-2">
                        <button
                            type="button"
                            @click="cancelForm"
                            class="rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                            title="Cancel"
                        >
                            <X class="h-5 w-5" />
                        </button>
                        <button
                            type="submit"
                            :disabled="isSubmitting"
                            class="rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                            :class="{ 'cursor-not-allowed opacity-75': isSubmitting }"
                            title="Save Changes"
                        >
                            <Save class="h-5 w-5" />
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </admin-layout>
</template>
