<script setup lang="ts">
import type { ImageData } from '@/components/ui/forms/image-upload/ui-image-upload';
import { Calendar, Copy, Download, Eye, FileText, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Props {
    images: ImageData[];
}

interface Emits {
    (event: 'image-deleted', imageId: number): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const hoveredImage = ref<number | null>(null);
const selectedImage = ref<ImageData | null>(null);
const showImageModal = ref(false);

const formatFileSize = (bytes: number): string => {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

const formatDate = (dateString: string): string => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const deleteImage = async (image: ImageData) => {
    if (!confirm(`Are you sure you want to delete "${image.original_filename}"?`)) {
        return;
    }

    try {
        const response = await fetch(`/admin/images/${image.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
        });

        const result = await response.json();

        if (result.success) {
            emit('image-deleted', image.id);
        } else {
            alert('Failed to delete image: ' + result.message);
        }
    } catch (error) {
        alert('Failed to delete image: ' + (error instanceof Error ? error.message : 'Unknown error'));
    }
};

const copyImageUrl = async (image: ImageData) => {
    try {
        await navigator.clipboard.writeText(image.url);
        // You could add a toast notification here
        console.log('Image URL copied to clipboard');
    } catch (error) {
        console.error('Failed to copy URL:', error);
    }
};

const downloadImage = (image: ImageData) => {
    const link = document.createElement('a');
    link.href = image.url;
    link.download = image.original_filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

const viewImage = (image: ImageData) => {
    selectedImage.value = image;
    showImageModal.value = true;
};

const closeImageModal = () => {
    showImageModal.value = false;
    selectedImage.value = null;
};

const handleImageHover = (imageId: number | null) => {
    hoveredImage.value = imageId;
};

const sortedImages = computed(() => {
    return [...props.images].sort((a, b) => {
        const dateA = new Date(a.created_at || 0).getTime();
        const dateB = new Date(b.created_at || 0).getTime();
        return dateB - dateA; // Newest first
    });
});
</script>

<template>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-lg font-medium text-gray-900">Image Library</h2>
            <p class="mt-1 text-sm text-gray-500">{{ images.length }} image{{ images.length !== 1 ? 's' : '' }} in your library</p>
        </div>

        <!-- Empty State -->
        <div v-if="images.length === 0" class="py-12 text-center">
            <div class="mx-auto mb-4 flex h-24 w-24 items-center justify-center rounded-full bg-gray-100">
                <FileText class="h-12 w-12 text-gray-400" />
            </div>
            <h3 class="mb-2 text-lg font-medium text-gray-900">No images yet</h3>
            <p class="mb-6 text-gray-500">Get started by uploading your first image.</p>
        </div>

        <!-- Images Grid -->
        <div v-else class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
            <div
                v-for="image in sortedImages"
                :key="image.id"
                class="group relative aspect-square transform cursor-pointer overflow-hidden rounded-lg bg-gray-100 transition-all duration-200 hover:scale-105 hover:shadow-lg"
                @mouseenter="handleImageHover(image.id)"
                @mouseleave="handleImageHover(null)"
            >
                <!-- Image -->
                <img
                    :src="image.url"
                    :alt="image.alt_text || image.original_filename"
                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                    @click="viewImage(image)"
                />

                <!-- Overlay -->
                <div
                    class="absolute inset-0 bg-black transition-opacity duration-200"
                    :class="hoveredImage === image.id ? 'opacity-40' : 'opacity-0'"
                />

                <!-- Actions -->
                <div
                    class="absolute inset-0 flex items-center justify-center transition-opacity duration-200"
                    :class="hoveredImage === image.id ? 'opacity-100' : 'opacity-0'"
                >
                    <div class="flex space-x-2">
                        <button
                            @click.stop="viewImage(image)"
                            class="rounded-full bg-white p-2 shadow-lg transition-colors hover:bg-gray-50"
                            title="View Image"
                        >
                            <Eye class="h-4 w-4 text-gray-700" />
                        </button>
                        <button
                            @click.stop="copyImageUrl(image)"
                            class="rounded-full bg-white p-2 shadow-lg transition-colors hover:bg-gray-50"
                            title="Copy URL"
                        >
                            <Copy class="h-4 w-4 text-gray-700" />
                        </button>
                        <button
                            @click.stop="downloadImage(image)"
                            class="rounded-full bg-white p-2 shadow-lg transition-colors hover:bg-gray-50"
                            title="Download"
                        >
                            <Download class="h-4 w-4 text-gray-700" />
                        </button>
                        <button
                            @click.stop="deleteImage(image)"
                            class="rounded-full bg-red-500 p-2 shadow-lg transition-colors hover:bg-red-600"
                            title="Delete Image"
                        >
                            <Trash2 class="h-4 w-4 text-white" />
                        </button>
                    </div>
                </div>

                <!-- Info Badge -->
                <div
                    class="absolute right-0 bottom-0 left-0 bg-gradient-to-t from-black/60 to-transparent p-3 transition-opacity duration-200"
                    :class="hoveredImage === image.id ? 'opacity-100' : 'opacity-0'"
                >
                    <p class="truncate text-xs font-medium text-white">
                        {{ image.original_filename }}
                    </p>
                    <p class="text-xs text-gray-200">
                        {{ formatFileSize(image.size) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Image Modal -->
        <div
            v-if="showImageModal && selectedImage"
            class="bg-opacity-75 fixed inset-0 z-50 flex items-center justify-center bg-black p-4"
            @click="closeImageModal"
        >
            <div class="relative max-h-full max-w-4xl overflow-hidden rounded-lg bg-white shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b p-4">
                    <div class="min-w-0 flex-1">
                        <h3 class="truncate text-lg font-medium text-gray-900">
                            {{ selectedImage.original_filename }}
                        </h3>
                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                            <span class="flex items-center">
                                <FileText class="mr-1 h-4 w-4" />
                                {{ formatFileSize(selectedImage.size) }}
                            </span>
                            <span class="flex items-center" v-if="selectedImage.created_at">
                                <Calendar class="mr-1 h-4 w-4" />
                                {{ formatDate(selectedImage.created_at) }}
                            </span>
                        </div>
                    </div>
                    <button @click="closeImageModal" class="ml-4 text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="max-h-96 overflow-auto p-4">
                    <img
                        :src="selectedImage.url"
                        :alt="selectedImage.alt_text || selectedImage.original_filename"
                        class="mx-auto h-auto max-h-80 w-full object-contain"
                    />

                    <div v-if="selectedImage.alt_text" class="mt-4 rounded-md bg-gray-50 p-3">
                        <p class="text-sm text-gray-600"><strong>Alt Text:</strong> {{ selectedImage.alt_text }}</p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-between border-t bg-gray-50 p-4">
                    <div class="flex space-x-2">
                        <button
                            @click="copyImageUrl(selectedImage)"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm leading-4 font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:outline-none"
                        >
                            <Copy class="mr-2 h-4 w-4" />
                            Copy URL
                        </button>
                        <button
                            @click="downloadImage(selectedImage)"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm leading-4 font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:outline-none"
                        >
                            <Download class="mr-2 h-4 w-4" />
                            Download
                        </button>
                    </div>
                    <button
                        @click="deleteImage(selectedImage)"
                        class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-2 text-sm leading-4 font-medium text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none"
                    >
                        <Trash2 class="mr-2 h-4 w-4" />
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}
</style>
