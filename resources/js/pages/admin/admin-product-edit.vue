<script setup lang="ts">
import AdminLayout from '@/layouts/admin-layout.vue';
import { ProductData } from '@/types/models/product';
import { ProductAdminEditPageProps as Props } from '@/types/pages/product';
import { router } from '@inertiajs/vue3';
import { Save, Trash2, X } from 'lucide-vue-next';
import { reactive, ref } from 'vue';

const props = defineProps<Props>();

const form = reactive<ProductData>({
    name: props.product.name,
    description: props.product.description,
    image_url: props.product.image_url,
    image: null as File | null,
    price: props.product.price,
    is_available: props.product.is_available,
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
    formData.append('_method', 'PATCH'); // For method spoofing

    router.post(`/admin/products/${props.product.id}`, formData, {
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

const deleteProduct = () => {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        router.delete(`/admin/products/${props.product.id}`, {
            onSuccess: () => {
                router.visit('/admin/products');
            },
        });
    }
};

const cancelForm = () => {
    router.visit('/admin/products');
};
</script>

<template>
    <admin-layout page-title="Edit Product" page-description="Update an existing product">
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

                    <!-- Show current image if it exists -->
                    <div v-if="form.image_url" class="mb-3">
                        <img :src="form.image_url" alt="Current product image" class="mb-2 h-40 w-auto rounded-md object-cover" />
                        <p class="text-sm text-gray-500">Current image</p>
                    </div>

                    <input
                        id="image"
                        type="file"
                        accept="image/*"
                        @change="(e) => (form.image = e.target.files?.[0] || null)"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200"
                    />
                    <p class="mt-1 text-sm text-gray-500">Upload a new product image (JPEG, PNG, GIF only, max 2MB)</p>
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

                <div class="flex justify-between">
                    <button
                        type="button"
                        @click="deleteProduct"
                        class="flex items-center gap-2 rounded-md bg-red-100 px-3 py-2 text-red-700 hover:bg-red-200 hover:text-red-800 focus:ring-2 focus:ring-red-300 focus:ring-offset-2 focus:outline-none"
                        title="Delete Product"
                    >
                        <Trash2 class="h-5 w-5" />
                        <span>Delete</span>
                    </button>

                    <div class="flex space-x-2">
                        <button
                            type="button"
                            @click="cancelForm"
                            class="flex items-center gap-2 rounded-md bg-gray-100 px-3 py-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                            title="Cancel"
                        >
                            <X class="h-5 w-5" />
                            <span>Cancel</span>
                        </button>
                        <button
                            type="submit"
                            :disabled="isSubmitting"
                            class="flex items-center gap-2 rounded-md bg-green-100 px-3 py-2 text-green-700 hover:bg-green-200 hover:text-green-800 focus:ring-2 focus:ring-green-300 focus:ring-offset-2 focus:outline-none"
                            :class="{ 'cursor-not-allowed opacity-75': isSubmitting }"
                            title="Save Changes"
                        >
                            <Save class="h-5 w-5" />
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </admin-layout>
</template>
