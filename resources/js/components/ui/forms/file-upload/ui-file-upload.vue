<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import type { UiFileUploadProps as Props, UiFileUploadEmits as Emits } from './ui-file-upload';
import { Upload, X, File as FileIcon, Image as ImageIcon } from 'lucide-vue-next';

const props = withDefaults(defineProps<Props>(), {
  multiple: false,
  accept: '',
  maxSize: 5 * 1024 * 1024,
  maxFiles: 10,
  disabled: false,
  placeholder: 'Select file(s) or drag and drop here',
  dropzoneText: 'Drag and drop files here',
  buttonText: 'Select File',
  showPreview: true,
});

const emit = defineEmits<Emits>();

const fileInputRef = ref<HTMLInputElement | null>(null);
const isDragging = ref(false);
const files = ref<File[]>([]);

watch(
  () => props.modelValue,
  newValue => {
    if (newValue) {
      if (Array.isArray(newValue)) {
        files.value = [...newValue];
      } else {
        files.value = [newValue];
      }
    } else {
      files.value = [];
    }
  },
  { immediate: true }
);

watch(
  files,
  newFiles => {
    if (props.multiple) {
      emit('update:modelValue', [...newFiles]);
    } else {
      emit('update:modelValue', newFiles.length > 0 ? newFiles[0] : undefined);
    }
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
    props.disabled ? 'cursor-not-allowed' : 'cursor-pointer',
  ]
    .filter(Boolean)
    .join(' ');
});

const handleClick = () => {
  if (props.disabled) return;
  fileInputRef.value?.click();
};

const handleDragOver = (event: DragEvent) => {
  if (props.disabled) return;
  event.preventDefault();
  isDragging.value = true;
};

const handleDragLeave = () => {
  isDragging.value = false;
};

const handleDrop = (event: DragEvent) => {
  if (props.disabled) return;
  event.preventDefault();
  isDragging.value = false;

  if (!event.dataTransfer) return;

  const droppedFiles = Array.from(event.dataTransfer.files);
  handleFiles(droppedFiles);
};

const handleFileInput = (event: Event) => {
  if (props.disabled) return;

  const input = event.target as HTMLInputElement;
  if (!input.files) return;

  const selectedFiles = Array.from(input.files);
  handleFiles(selectedFiles);

  input.value = '';
};

const handleFiles = (newFiles: File[]) => {
  if (props.disabled) return;

  let validFiles = props.accept ? newFiles.filter(file => isFileTypeAccepted(file)) : newFiles;

  validFiles = validFiles.filter(file => {
    const isValid = file.size <= props.maxSize;
    if (!isValid) {
      emit(
        'error',
        `File "${file.name}" exceeds the maximum size of ${formatFileSize(props.maxSize)}`
      );
    }
    return isValid;
  });

  if (props.multiple) {
    if (files.value.length + validFiles.length > props.maxFiles) {
      emit('error', `You can only upload a maximum of ${props.maxFiles} files`);
      validFiles = validFiles.slice(0, props.maxFiles - files.value.length);
    }

    validFiles.forEach(file => {
      files.value.push(file);
      emit('file-added', file);
    });
  } else {
    if (validFiles.length > 0) {
      const file = validFiles[0];
      files.value = [file];
      emit('file-added', file);
    }
  }

  emit('change', props.multiple ? files.value : files.value[0] || null);
};

const removeFile = (index: number) => {
  if (props.disabled) return;

  const file = files.value[index];
  files.value.splice(index, 1);
  emit('file-removed', file);
  emit('change', props.multiple ? files.value : files.value[0] || null);
};

const isFileTypeAccepted = (file: File): boolean => {
  if (!props.accept) return true;

  const acceptedTypes = props.accept.split(',').map(type => type.trim().toLowerCase());
  const fileType = file.type.toLowerCase();
  const fileExtension = `.${file.name.split('.').pop()?.toLowerCase()}`;

  return acceptedTypes.some(type => {
    if (fileType === type) return true;

    if (type.endsWith('/*') && fileType.startsWith(type.replace('*', ''))) return true;

    if (type.startsWith('.') && fileExtension === type) return true;

    return false;
  });
};

const formatFileSize = (bytes: number): string => {
  if (bytes === 0) return '0 Bytes';

  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));

  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

const getFileIcon = (file: File) => {
  if (file.type.startsWith('image/')) {
    return ImageIcon;
  }
  return FileIcon;
};

const getFilePreview = (file: File) => {
  if (file.type.startsWith('image/')) {
    return URL.createObjectURL(file);
  }
  return null;
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
        :accept="accept"
        :multiple="multiple"
        :disabled="disabled"
        @change="handleFileInput"
      />

      <upload class="w-10 h-10 text-gray-400 mb-2" />

      <div class="text-sm text-center">
        <p class="font-medium text-gray-700">{{ isDragging ? dropzoneText : placeholder }}</p>
        <p class="text-gray-500 mt-1">or</p>
        <button
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

    <div v-if="showPreview && files.length > 0" class="mt-4 space-y-2">
      <div
        v-for="(file, index) in files"
        :key="index"
        class="flex items-center p-3 bg-gray-50 border rounded-md"
      >
        <div class="flex-shrink-0 mr-3">
          <img
            v-if="getFilePreview(file)"
            :src="getFilePreview(file)"
            class="w-10 h-10 object-cover rounded"
            alt="File preview"
          />
          <component :is="getFileIcon(file)" v-else class="w-10 h-10 text-gray-400" />
        </div>

        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-gray-900 truncate">
            {{ file.name }}
          </p>
          <p class="text-xs text-gray-500">
            {{ formatFileSize(file.size) }}
          </p>
        </div>

        <button
          v-if="!disabled"
          type="button"
          class="ml-2 text-gray-400 hover:text-gray-500 focus:outline-none"
          @click.stop="removeFile(index)"
        >
          <x class="w-5 h-5" />
        </button>
      </div>
    </div>
  </div>
</template>
