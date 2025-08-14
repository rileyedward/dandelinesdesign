<script setup lang="ts">
import Editor from '@tinymce/tinymce-vue';
import { computed } from 'vue';

interface Props {
    modelValue: string;
    label?: string;
    placeholder?: string;
    error?: string;
    help?: string;
    disabled?: boolean;
    required?: boolean;
    height?: number;
}

const props = withDefaults(defineProps<Props>(), {
    label: '',
    placeholder: '',
    error: '',
    help: '',
    disabled: false,
    required: false,
    height: 400,
});

const emit = defineEmits<{
    'update:modelValue': [value: string];
}>();

const editorConfig = computed(() => ({
    apiKey: import.meta.env.VITE_TINYMCE_API_KEY,
    height: props.height,
    menubar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    skin: 'oxide',
    content_css: 'default',
    branding: false,
    promotion: false,
}));

const handleEditorChange = (content: string) => {
    emit('update:modelValue', content);
};
</script>

<template>
    <div class="space-y-2">
        <label 
            v-if="label" 
            class="block text-sm font-medium text-gray-700"
            :class="{ 'after:content-[\' *\'] after:text-red-500': required }"
        >
            {{ label }}
        </label>
        
        <div class="relative">
            <Editor
                :model-value="modelValue"
                :init="editorConfig"
                :disabled="disabled"
                @update:model-value="handleEditorChange"
                :class="[
                    'block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500',
                    error ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '',
                    disabled ? 'bg-gray-50 cursor-not-allowed' : ''
                ]"
            />
        </div>
        
        <p v-if="help && !error" class="text-sm text-gray-600">
            {{ help }}
        </p>
        
        <p v-if="error" class="text-sm text-red-600">
            {{ error }}
        </p>
    </div>
</template>