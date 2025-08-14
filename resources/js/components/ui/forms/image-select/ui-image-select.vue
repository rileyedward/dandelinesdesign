<script setup lang="ts">
import type { ImageData } from '@/components/ui/forms/image-upload/ui-image-upload';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import { cn } from '@/lib/utils';
import axios from 'axios';
import { Check, X } from 'lucide-vue-next';
import { computed, onMounted, ref, watch } from 'vue';

interface Props {
    modelValue?: string;
    label?: string;
    error?: string;
    placeholder?: string;
    disabled?: boolean;
    required?: boolean;
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    placeholder: 'Select an image',
});

const emit = defineEmits<{
    'update:modelValue': [value: string];
}>();

const showModal = ref(false);
const images = ref<ImageData[]>([]);
const loading = ref(false);
const selectedImage = ref<ImageData | null>(null);

const computedValue = computed({
    get: () => props.modelValue || '',
    set: (value: string) => emit('update:modelValue', value),
});

const selectedImageData = computed(() => {
    if (!computedValue.value) return null;
    return images.value.find(img => img.url === computedValue.value) || null;
});

const fetchImages = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/admin/images/list');
        if (response.data.success) {
            images.value = response.data.data;
        }
    } catch (error) {
        console.error('Failed to fetch images:', error);
    } finally {
        loading.value = false;
    }
};

const selectImage = (image: ImageData) => {
    selectedImage.value = image;
};

const confirmSelection = () => {
    if (selectedImage.value) {
        computedValue.value = selectedImage.value.url;
        showModal.value = false;
    }
};

const clearSelection = () => {
    computedValue.value = '';
    selectedImage.value = null;
};

const openModal = () => {
    showModal.value = true;
    selectedImage.value = selectedImageData.value;
    fetchImages();
};

const closeModal = () => {
    showModal.value = false;
    selectedImage.value = null;
};

onMounted(() => {
    if (computedValue.value) {
        fetchImages();
    }
});

watch(() => props.modelValue, (newValue) => {
    if (newValue && images.value.length === 0) {
        fetchImages();
    }
});
</script>

<template>
    <div :class="cn('space-y-2', props.class)">
        <label v-if="label" class="block text-sm font-medium text-gray-700">
            {{ label }}
            <span v-if="required" class="text-red-500 ml-1">*</span>
        </label>
        
        <div class="space-y-3">
            <!-- Current Selection Preview -->
            <div v-if="selectedImageData" class="relative rounded-lg border-2 border-dashed border-gray-300 p-4">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img 
                            :src="selectedImageData.url" 
                            :alt="selectedImageData.alt_text || selectedImageData.original_filename"
                            class="h-16 w-16 rounded-lg object-cover"
                        />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ selectedImageData.original_filename }}
                        </p>
                        <p class="text-sm text-gray-500 truncate">
                            {{ selectedImageData.alt_text || 'No alt text' }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <UiButton
                            size="sm"
                            variant="outline"
                            :prefix-icon="X"
                            @click="clearSelection"
                            class="text-gray-400 hover:text-gray-600"
                        />
                    </div>
                </div>
            </div>

            <!-- Select Button -->
            <UiButton
                :disabled="disabled"
                variant="outline"
                @click="openModal"
                class="w-full justify-center"
            >
                {{ selectedImageData ? 'Change Image' : placeholder }}
            </UiButton>
        </div>

        <!-- Error Message -->
        <p v-if="error" class="text-sm text-red-600">{{ error }}</p>

        <!-- Selection Modal -->
        <UiModal :show="showModal" @close="closeModal" title="Select Image" size="4xl">
            <!-- Content -->
            <div class="p-6">
                <div v-if="loading" class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                </div>

                <div v-else-if="images.length === 0" class="text-center py-12">
                    <p class="text-gray-500">No images available. Upload some images first.</p>
                </div>

                <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div
                        v-for="image in images"
                        :key="image.id"
                        class="relative cursor-pointer group"
                        @click="selectImage(image)"
                    >
                        <div
                            :class="cn(
                                'relative rounded-lg border-2 overflow-hidden transition-all duration-200',
                                selectedImage?.id === image.id
                                    ? 'border-purple-500 ring-2 ring-purple-200'
                                    : 'border-gray-200 hover:border-gray-300'
                            )"
                        >
                            <img
                                :src="image.url"
                                :alt="image.alt_text || image.original_filename"
                                class="w-full h-32 object-cover"
                            />
                            
                            <!-- Selection Overlay -->
                            <div
                                v-if="selectedImage?.id === image.id"
                                class="absolute inset-0 bg-purple-500 bg-opacity-20 flex items-center justify-center"
                            >
                                <div class="bg-purple-500 rounded-full p-1">
                                    <Check class="h-4 w-4 text-white" />
                                </div>
                            </div>

                            <!-- Hover Overlay -->
                            <div
                                v-else
                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200"
                            ></div>
                        </div>

                        <!-- Image Info -->
                        <div class="mt-2">
                            <p class="text-xs font-medium text-gray-900 truncate">
                                {{ image.original_filename }}
                            </p>
                            <p class="text-xs text-gray-500 truncate">
                                {{ image.alt_text || 'No alt text' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <template #footer>
                <div class="flex items-center justify-end space-x-3">
                    <UiButton variant="outline" @click="closeModal">
                        Cancel
                    </UiButton>
                    <UiButton
                        :disabled="!selectedImage"
                        @click="confirmSelection"
                    >
                        Select Image
                    </UiButton>
                </div>
            </template>
        </UiModal>
    </div>
</template>