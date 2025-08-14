<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import type { UiImageUploadProps as Props, UiImageUploadEmits as Emits, ImageData } from './ui-image-upload';
import { Upload, X, Image as ImageIcon, Loader2 } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';

const props = withDefaults(defineProps<Props>(), {
  multiple: false,
  maxSize: 10 * 1024 * 1024, // 10MB
  maxFiles: 10,
  disabled: false,
  placeholder: 'Select image(s) or drag and drop here',
  dropzoneText: 'Drag and drop images here',
  buttonText: 'Select Images',
  showPreview: true,
  uploadUrl: '/admin/images',
});

const emit = defineEmits<Emits>();

const fileInputRef = ref<HTMLInputElement | null>(null);
const isDragging = ref(false);
const isUploading = ref(false);
const images = ref<ImageData[]>([]);

watch(
  () => props.modelValue,
  newValue => {
    if (newValue) {
      if (Array.isArray(newValue)) {
        images.value = [...newValue];
      } else {
        images.value = [newValue];
      }
    } else {
      images.value = [];
    }
  },
  { immediate: true }
);

watch(
  images,
  newImages => {
    if (props.multiple) {
      emit('update:modelValue', [...newImages]);
    } else {
      emit('update:modelValue', newImages.length > 0 ? newImages[0] : undefined);
    }
    emit('change', props.multiple ? [...newImages] : newImages[0] || undefined);
  },
  { deep: true }
);

const containerClasses = computed(() => {
  return ['w-full', props.disabled ? 'opacity-60 cursor-not-allowed' : '']
    .filter(Boolean)
    .join(' ');
});

const dropzoneClasses = computed(() => {
  return [
    'border-2 border-dashed rounded-lg p-6',
    'flex flex-col items-center justify-center',
    'transition-colors duration-200',
    isDragging.value ? 'border-purple-500 bg-purple-50' : 'border-gray-300 hover:border-purple-400',
    props.error ? 'border-red-500 bg-red-50' : '',
    props.disabled || isUploading.value ? 'cursor-not-allowed' : 'cursor-pointer',
  ]
    .filter(Boolean)
    .join(' ');
});

const handleClick = () => {
  if (props.disabled || isUploading.value) return;
  fileInputRef.value?.click();
};

const handleDragOver = (event: DragEvent) => {
  if (props.disabled || isUploading.value) return;
  event.preventDefault();
  isDragging.value = true;
};

const handleDragLeave = () => {
  isDragging.value = false;
};

const handleDrop = (event: DragEvent) => {
  if (props.disabled || isUploading.value) return;
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
  if (props.multiple) {
    if (images.value.length + validFiles.length > props.maxFiles) {
      emit('error', `You can only upload a maximum of ${props.maxFiles} images`);
      validFiles = validFiles.slice(0, props.maxFiles - images.value.length);
    }
  } else {
    validFiles = validFiles.slice(0, 1);
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
      
      if (props.multiple) {
        images.value.push(imageData);
      } else {
        images.value = [imageData];
      }
      
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

    <div
      :class="dropzoneClasses"
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
        :multiple="multiple"
        :disabled="disabled || isUploading"
        @change="handleFileInput"
      />

      <Loader2 v-if="isUploading" class="w-10 h-10 text-purple-500 mb-2 animate-spin" />
      <Upload v-else class="w-10 h-10 text-gray-400 mb-2" />

      <div class="text-sm text-center">
        <p class="font-medium text-gray-700">
          {{ isUploading ? 'Uploading...' : (isDragging ? dropzoneText : placeholder) }}
        </p>
        <p v-if="!isUploading" class="text-gray-500 mt-1">or</p>
        <button
          v-if="!isUploading"
          type="button"
          class="mt-2 px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="disabled"
        >
          {{ buttonText }}
        </button>
      </div>

      <div v-if="helperText" class="mt-2 text-xs text-gray-500">
        {{ helperText }}
      </div>

      <div v-if="error" class="mt-2 text-xs text-red-500">
        {{ error }}
      </div>
    </div>

    <div v-if="showPreview && images.length > 0" class="mt-4 space-y-2">
      <div
        v-for="(image, index) in images"
        :key="image.id"
        class="flex items-center p-3 bg-gray-50 border rounded-md"
      >
        <div class="flex-shrink-0 mr-3">
          <img
            :src="image.url"
            :alt="image.alt_text || image.original_filename"
            class="w-16 h-16 object-cover rounded"
          />
        </div>

        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-gray-900 truncate">
            {{ image.original_filename }}
          </p>
          <p class="text-xs text-gray-500">
            {{ formatFileSize(image.size) }}
          </p>
          <p v-if="image.alt_text" class="text-xs text-gray-500 italic">
            Alt: {{ image.alt_text }}
          </p>
        </div>

        <button
          v-if="!disabled"
          type="button"
          class="ml-2 text-gray-400 hover:text-gray-500 focus:outline-none"
          @click.stop="removeImage(index)"
        >
          <X class="w-5 h-5" />
        </button>
      </div>
    </div>
  </div>
</template>