<script setup lang="ts">
import AdminLayout from '@/layouts/admin-layout.vue';
import { BlogPostData } from '@/types/models/blog-post';
import { router } from '@inertiajs/vue3';
import { Save, X } from 'lucide-vue-next';
import { reactive, ref } from 'vue';

const form = reactive<BlogPostData>({
    title: '',
    content: '',
    image_url: null,
    is_published: false,
});

const errors = reactive<Record<string, string>>({});
const isSubmitting = ref(false);

const submitForm = () => {
    isSubmitting.value = true;

    router.post('/admin/blog', form, {
        onSuccess: () => {
            router.visit('/admin/blog');
        },
        onError: (err) => {
            errors.value = err;
            isSubmitting.value = false;
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};

const cancelForm = () => {
    router.visit('/admin/blog');
};
</script>

<template>
    <admin-layout page-title="Create Blog Post" page-description="Create a new blog post">
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
                    <label for="image_url" class="mb-2 block text-sm font-medium text-gray-700">Image URL</label>
                    <input
                        id="image_url"
                        v-model="form.image_url"
                        type="text"
                        class="block w-full rounded-md border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                    />
                    <p v-if="errors.image_url" class="mt-1 text-sm text-red-600">{{ errors.image_url }}</p>
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
                        <label for="is_published" class="ml-2 block text-sm font-medium text-gray-700">Publish immediately</label>
                    </div>
                    <p v-if="errors.is_published" class="mt-1 text-sm text-red-600">{{ errors.is_published }}</p>
                </div>

                <div class="flex justify-end space-x-2">
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
                        title="Create Blog Post"
                    >
                        <Save class="h-5 w-5" />
                    </button>
                </div>
            </form>
        </div>
    </admin-layout>
</template>
