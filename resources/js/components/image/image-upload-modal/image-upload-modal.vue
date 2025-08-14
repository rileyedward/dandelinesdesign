<script setup lang="ts">
import type { ImageData } from '@/components/ui/forms/image-upload/ui-image-upload';
import UiMultiImageUpload from '@/components/ui/forms/multi-image-upload/ui-multi-image-upload.vue';
import { X } from 'lucide-vue-next';
import { ref, watch } from 'vue';

interface Props {
    show: boolean;
}

interface Emits {
    (event: 'close'): void;
    (event: 'image-uploaded', image: ImageData): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const uploadedImages = ref<ImageData[]>([]);
const errorMessage = ref<string>('');
const successMessage = ref<string>('');

watch(
    () => props.show,
    (newShow) => {
        if (newShow) {
            uploadedImages.value = [];
            errorMessage.value = '';
            successMessage.value = '';
        }
    },
);

const handleClose = () => {
    emit('close');
};

const handleUploadSuccess = (image: ImageData) => {
    uploadedImages.value.push(image);
    emit('image-uploaded', image);
    successMessage.value = `Successfully uploaded "${image.original_filename}"`;
    errorMessage.value = '';

    setTimeout(() => {
        successMessage.value = '';
    }, 3000);
};

const handleUploadError = (error: string) => {
    errorMessage.value = error;
    successMessage.value = '';
};

const handleError = (error: string) => {
    errorMessage.value = error;
    successMessage.value = '';
};

const handleImageRemove = (image: ImageData) => {
    uploadedImages.value = uploadedImages.value.filter((img) => img.id !== image.id);
};

const closeModal = () => {
    if (uploadedImages.value.length > 0) {
        const message =
            uploadedImages.value.length === 1 ? `Successfully uploaded 1 image` : `Successfully uploaded ${uploadedImages.value.length} images`;

        // You could show a toast notification here instead
        console.log(message);
    }

    handleClose();
};
</script>

<template>
    <!-- Modal Backdrop -->
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="bg-opacity-75 fixed inset-0 bg-gray-500 transition-opacity" @click="closeModal"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div
                class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle"
            >
                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900" id="modal-title">Upload Images</h3>
                        <p class="mt-1 text-sm text-gray-500">Add new images to your library. You can upload multiple images at once.</p>
                    </div>
                    <button
                        @click="closeModal"
                        class="rounded-md p-1 text-gray-400 hover:text-gray-500 focus:ring-2 focus:ring-purple-500 focus:outline-none"
                    >
                        <span class="sr-only">Close</span>
                        <X class="h-6 w-6" />
                    </button>
                </div>

                <!-- Success Message -->
                <div v-if="successMessage" class="mb-4 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ successMessage }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div v-if="errorMessage" class="mb-4 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                {{ errorMessage }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Upload Component -->
                <div class="mb-6">
                    <ui-multi-image-upload
                        v-model="uploadedImages"
                        :max-files="20"
                        :max-size="10 * 1024 * 1024"
                        placeholder="Drop images here or click to select"
                        button-text="Select Images"
                        helper-text="Support: JPEG, PNG, GIF, WebP. Max size: 10MB per image."
                        @upload-success="handleUploadSuccess"
                        @upload-error="handleUploadError"
                        @error="handleError"
                        @remove="handleImageRemove"
                    />
                </div>

                <!-- Upload Stats -->
                <div v-if="uploadedImages.length > 0" class="mb-6 rounded-lg bg-gray-50 p-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600"> {{ uploadedImages.length }} image{{ uploadedImages.length !== 1 ? 's' : '' }} uploaded </span>
                        <span class="text-gray-600">
                            Total size: {{ Math.round((uploadedImages.reduce((total, img) => total + img.size, 0) / 1024 / 1024) * 100) / 100 }} MB
                        </span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end space-x-3">
                    <button
                        @click="closeModal"
                        type="button"
                        class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:outline-none"
                    >
                        {{ uploadedImages.length > 0 ? 'Done' : 'Cancel' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
