<script setup lang="ts">
import ImageUploadModal from '@/components/image/image-upload-modal/image-upload-modal.vue';
import ImagesList from '@/components/image/images-list/images-list.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import type { ImageData } from '@/components/ui/forms/image-upload/ui-image-upload';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    images: ImageData[];
}

const props = defineProps<Props>();

const showUploadModal = ref(false);
const imagesList = ref<ImageData[]>([...props.images]);

const handleImageUploaded = (image: ImageData) => {
    imagesList.value.unshift(image);
};

const handleImageDeleted = (imageId: number) => {
    imagesList.value = imagesList.value.filter((image) => image.id !== imageId);
};

const openUploadModal = () => {
    showUploadModal.value = true;
};

const closeUploadModal = () => {
    showUploadModal.value = false;
};
</script>

<template>
    <Head title="Images" />

    <SidebarLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Images</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage your image library for use across your website</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <UiButton label="New" :prefix-icon="Plus" @click="openUploadModal" class="inline-flex items-center" />
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-lg bg-white p-6 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex h-8 w-8 items-center justify-center rounded-md bg-purple-100">
                                <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500">Total Images</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ imagesList.length }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex h-8 w-8 items-center justify-center rounded-md bg-green-100">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500">Storage Used</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ Math.round(imagesList.reduce((total, img) => total + img.size, 0) / 1024 / 1024) }} MB
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-100">
                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500">Recent Uploads</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{
                                        imagesList.filter((img) => {
                                            const uploadDate = new Date(img.created_at || Date.now());
                                            const dayAgo = new Date(Date.now() - 24 * 60 * 60 * 1000);
                                            return uploadDate > dayAgo;
                                        }).length
                                    }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images List -->
            <div class="rounded-lg bg-white shadow">
                <images-list :images="imagesList" @image-deleted="handleImageDeleted" />
            </div>
        </div>

        <!-- Upload Modal -->
        <image-upload-modal :show="showUploadModal" @close="closeUploadModal" @image-uploaded="handleImageUploaded" />
    </SidebarLayout>
</template>
