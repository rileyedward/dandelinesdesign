<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import type { UiMultiImageUploadProps as Props, UiMultiImageUploadEmits as Emits, ImageData } from './ui-multi-image-upload';
import { Upload, X, Loader2, GripVertical, Plus } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';

const props = withDefaults(defineProps<Props>(), {
  maxSize: 10 * 1024 * 1024, // 10MB
  maxFiles: 20,
  disabled: false,
  placeholder: 'Add images to your gallery',
  dropzoneText: 'Drop images here to upload',
  buttonText: 'Add Images',
  showPreview: true,
  uploadUrl: '/admin/images',
  allowReorder: true,
});

const emit = defineEmits<Emits>();

const fileInputRef = ref<HTMLInputElement | null>(null);
const isDragging = ref(false);
const isUploading = ref(false);
const images = ref<ImageData[]>([]);
const draggedIndex = ref<number | null>(null);

watch(
  () => props.modelValue,
  newValue => {
    images.value = newValue ? [...newValue] : [];
  },
  { immediate: true }
);

watch(
  images,
  newImages => {
    emit('update:modelValue', [...newImages]);
    emit('change', [...newImages]);
  },
  { deep: true }
);

const containerClasses = computed(() => {
  return ['w-full', props.disabled ? 'opacity-60 cursor-not-allowed' : '']
    .filter(Boolean)
    .join(' ');
});

const canAddMore = computed(() => {
  return images.value.length < props.maxFiles;
});

const handleClick = () => {
  if (props.disabled || isUploading.value || !canAddMore.value) return;
  fileInputRef.value?.click();
};

const handleDragOver = (event: DragEvent) => {
  if (props.disabled || isUploading.value || !canAddMore.value) return;
  event.preventDefault();
  isDragging.value = true;
};

const handleDragLeave = () => {
  isDragging.value = false;
};

const handleDrop = (event: DragEvent) => {
  if (props.disabled || isUploading.value || !canAddMore.value) return;
  event.preventDefault();
  isDragging.value = false;

  if (!event.dataTransfer) return;

  const droppedFiles = Array.from(event.dataTransfer.files);
  handleFiles(droppedFiles);
};

const handleFileInput = (event: Event) => {
  if (props.disabled || isUploading.value) return;

  const input = event.target as HTMLInputElement;
  if (!input.files) return;

  const selectedFiles = Array.from(input.files);
  handleFiles(selectedFiles);

  input.value = '';
};

const handleFiles = async (newFiles: File[]) => {
  if (props.disabled || isUploading.value) return;

  // Filter to only images
  let validFiles = newFiles.filter(file => file.type.startsWith('image/'));
  
  if (validFiles.length !== newFiles.length) {
    emit('error', 'Only image files are allowed');
  }

  // Check file sizes
  validFiles = validFiles.filter(file => {
    const isValid = file.size <= props.maxSize;
    if (!isValid) {
      emit('error', `Image "${file.name}" exceeds the maximum size of ${formatFileSize(props.maxSize)}`);
    }
    return isValid;
  });

  // Check max files
  if (images.value.length + validFiles.length > props.maxFiles) {
    emit('error', `You can only upload a maximum of ${props.maxFiles} images`);
    validFiles = validFiles.slice(0, props.maxFiles - images.value.length);
  }

  // Upload files
  for (const file of validFiles) {
    await uploadFile(file);
  }
};

const uploadFile = async (file: File) => {
  isUploading.value = true;
  
  try {
    const formData = new FormData();
    formData.append('image', file);
    
    // Get CSRF token from Inertia page props
    const page = usePage();
    const csrfToken = page.props.csrf_token || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    const response = await fetch(props.uploadUrl, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json',
      },
    });

    const result = await response.json();

    if (result.success) {
      const imageData: ImageData = result.data;
      images.value.push(imageData);
      emit('upload-success', imageData);
    } else {
      emit('upload-error', result.message || 'Upload failed');
      emit('error', result.message || 'Upload failed');
    }
  } catch (error) {
    const errorMessage = error instanceof Error ? error.message : 'Upload failed';
    emit('upload-error', errorMessage);
    emit('error', errorMessage);
  } finally {
    isUploading.value = false;
  }
};

const removeImage = (index: number) => {
  if (props.disabled) return;

  const image = images.value[index];
  images.value.splice(index, 1);
  emit('remove', image);
};

const startDrag = (index: number) => {
  if (!props.allowReorder) return;
  draggedIndex.value = index;
};

const handleImageDragOver = (event: DragEvent, index: number) => {
  if (!props.allowReorder || draggedIndex.value === null) return;
  event.preventDefault();
};

const handleImageDrop = (event: DragEvent, dropIndex: number) => {
  if (!props.allowReorder || draggedIndex.value === null) return;
  event.preventDefault();

  const dragIndex = draggedIndex.value;
  if (dragIndex === dropIndex) return;

  const draggedImage = images.value[dragIndex];
  images.value.splice(dragIndex, 1);
  images.value.splice(dropIndex, 0, draggedImage);
  
  draggedIndex.value = null;
  emit('reorder', [...images.value]);
};

const formatFileSize = (bytes: number): string => {
  if (bytes === 0) return '0 Bytes';

  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));

  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};
</script>

<template>
  <div :class="containerClasses">
    <div v-if="label" class="mb-2 text-sm font-medium text-gray-700">
      {{ label }}
    </div>

    <!-- Upload Zone -->
    <div
      v-if="canAddMore"
      class="border-2 border-dashed rounded-lg p-6 flex flex-col items-center justify-center transition-colors duration-200 cursor-pointer hover:border-purple-400"
      :class="{
        'border-purple-500 bg-purple-50': isDragging,
        'border-gray-300': !isDragging,
        'border-red-500 bg-red-50': error,
        'cursor-not-allowed opacity-60': disabled || isUploading,
      }"
      @click="handleClick"
      @dragover="handleDragOver"
      @dragleave="handleDragLeave"
      @drop="handleDrop"
    >
      <input
        ref="fileInputRef"
        type="file"
        class="hidden"
        accept="image/*"
        multiple
        :disabled="disabled || isUploading"
        @change="handleFileInput"
      />

      <Loader2 v-if="isUploading" class="w-10 h-10 text-purple-500 mb-2 animate-spin" />
      <Plus v-else class="w-10 h-10 text-gray-400 mb-2" />

      <div class="text-sm text-center">
        <p class="font-medium text-gray-700">
          {{ isUploading ? 'Uploading...' : (isDragging ? dropzoneText : placeholder) }}
        </p>
        <p v-if="!isUploading" class="text-gray-500 mt-1">
          {{ images.length }} / {{ maxFiles }} images
        </p>
        <button
          v-if="!isUploading"
          type="button"
          class="mt-2 px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="disabled"
        >
          {{ buttonText }}
        </button>
      </div>
    </div>

    <!-- Help Text and Errors -->
    <div v-if="helperText" class="mt-2 text-xs text-gray-500">
      {{ helperText }}
    </div>

    <div v-if="error" class="mt-2 text-xs text-red-500">
      {{ error }}
    </div>

    <!-- Image Grid -->
    <div v-if="showPreview && images.length > 0" class="mt-6">
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div
          v-for="(image, index) in images"
          :key="image.id"
          class="relative group bg-gray-100 rounded-lg overflow-hidden aspect-square"
          :draggable="allowReorder"
          @dragstart="startDrag(index)"
          @dragover="handleImageDragOver($event, index)"
          @drop="handleImageDrop($event, index)"
        >
          <!-- Drag Handle -->
          <div
            v-if="allowReorder"
            class="absolute top-2 left-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity cursor-move"
          >
            <GripVertical class="w-4 h-4 text-white drop-shadow-lg" />
          </div>

          <!-- Image -->
          <img
            :src="image.url"
            :alt="image.alt_text || image.original_filename"
            class="w-full h-full object-cover"
          />

          <!-- Overlay with info -->
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-end">
            <div class="p-2 text-white text-xs opacity-0 group-hover:opacity-100 transition-opacity w-full">
              <p class="truncate font-medium">{{ image.original_filename }}</p>
              <p class="text-gray-200">{{ formatFileSize(image.size) }}</p>
            </div>
          </div>

          <!-- Remove Button -->
          <button
            v-if="!disabled"
            type="button"
            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            @click.stop="removeImage(index)"
          >
            <X class="w-3 h-3" />
          </button>
        </div>
      </div>

      <!-- Image Count -->
      <div class="mt-4 text-sm text-gray-500 text-center">
        {{ images.length }} image{{ images.length !== 1 ? 's' : '' }} uploaded
        <span v-if="maxFiles > images.length">
          ({{ maxFiles - images.length }} remaining)
        </span>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else-if="showPreview && images.length === 0 && !canAddMore" class="mt-6 text-center py-8 text-gray-500">
      <Upload class="w-12 h-12 mx-auto mb-4 text-gray-300" />
      <p>No images uploaded yet</p>
    </div>
  </div>
</template>