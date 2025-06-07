<script setup lang="ts">
import AdminLayout from '@/layouts/admin-layout.vue';
import { ProductData } from '@/types/models/product';
import { router } from '@inertiajs/vue3';
import { Save, X } from 'lucide-vue-next';
import { reactive, ref } from 'vue';

const form = reactive<ProductData>({
    name: '',
    description: '',
    image_url: null,
    image: null as File | null,
    price: 0,
    is_available: true,
});

const errors = reactive<Record<string, string>>({});
const isSubmitting = ref(false);

const submitForm = () => {
    isSubmitting.value = true;

    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('description', form.description);
    formData.append('price', form.price.toString());
    if (form.image) {
        formData.append('image', form.image);
    }
    if (form.image_url) {
        formData.append('image_url', form.image_url);
    }
    formData.append('is_available', form.is_available ? '1' : '0');

    router.post('/admin/products', formData, {
        onSuccess: () => {
            router.visit('/admin/products');
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

const cancelForm = () => {
    router.visit('/admin/products');
};
</script>

<template>
    <admin-layout page-title="Create Product" page-description="Create a new product">
        <div class="container mx-auto">
            <form @submit.prevent="submitForm" class="rounded-lg bg-white p-6 shadow-md">
                <div class="mb-6">
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Name *</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="block w-full rounded-md border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                </div>

                <div class="mb-6">
                    <label for="image" class="mb-2 block text-sm font-medium text-gray-700">Product Image</label>
                    <input
                        id="image"
                        type="file"
                        accept="image/*"
                        @change="(e) => (form.image = e.target.files?.[0] || null)"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200"
                    />
                    <p class="mt-1 text-sm text-gray-500">Upload a product image (JPEG, PNG, GIF only, max 2MB)</p>
                    <p v-if="errors.image" class="mt-1 text-sm text-red-600">{{ errors.image }}</p>
                </div>

                <div class="mb-6">
                    <label for="price" class="mb-2 block text-sm font-medium text-gray-700">Price *</label>
                    <input
                        id="price"
                        v-model.number="form.price"
                        type="number"
                        step="0.01"
                        min="0"
                        class="block w-full rounded-md border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                    <p v-if="errors.price" class="mt-1 text-sm text-red-600">{{ errors.price }}</p>
                </div>

                <div class="mb-6">
                    <label for="description" class="mb-2 block text-sm font-medium text-gray-700">Description *</label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="10"
                        class="block w-full rounded-md border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                        required
                    ></textarea>
                    <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
                </div>

                <div class="mb-6">
                    <div class="flex items-center">
                        <input
                            id="is_available"
                            v-model="form.is_available"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        />
                        <label for="is_available" class="ml-2 block text-sm font-medium text-gray-700">Available?</label>
                    </div>
                    <p v-if="errors.is_available" class="mt-1 text-sm text-red-600">{{ errors.is_available }}</p>
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
                        title="Create Product"
                    >
                        <Save class="h-5 w-5" />
                    </button>
                </div>
            </form>
        </div>
    </admin-layout>
</template>
