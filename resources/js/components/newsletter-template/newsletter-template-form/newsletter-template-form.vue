<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiRichTextEditor from '@/components/ui/forms/rich-text-editor/ui-rich-text-editor.vue';
import UiTextarea from '@/components/ui/forms/textarea/ui-textarea.vue';
import type { InertiaForm } from '@inertiajs/vue3';
import { Calendar, Edit, Eye, Mail, Save } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    form: InertiaForm<{
        name: string;
        subject: string;
        content: string;
        preview_text: string;
    }>;
    submitLabel?: string;
    isEditing?: boolean;
    showPreviewToggle?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    submitLabel: 'Save Template',
    isEditing: false,
    showPreviewToggle: true,
});

const form = ref(props.form);

const emit = defineEmits<{
    submit: [];
}>();

const isPreviewMode = ref(false);

const togglePreview = () => {
    isPreviewMode.value = !isPreviewMode.value;
};

const handleSubmit = () => {
    emit('submit');
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <div class="space-y-6">
        <!-- Preview/Edit Toggle -->
        <div v-if="showPreviewToggle" class="flex justify-end">
            <ui-button
                :label="isPreviewMode ? 'Edit Template' : 'Preview Template'"
                variant="outline"
                size="sm"
                :prefix-icon="isPreviewMode ? Edit : Eye"
                @click="togglePreview"
            />
        </div>

        <!-- Edit Form -->
        <div v-if="!isPreviewMode" class="rounded-lg border bg-white p-6 shadow-sm">
            <form @submit.prevent="handleSubmit" class="space-y-6">
                <!-- Template Name -->
                <div>
                    <ui-input
                        v-model="form.name"
                        label="Template Name"
                        placeholder="Enter template name"
                        :error="form.errors.name"
                        required
                        help="Internal name for this template"
                    />
                </div>

                <!-- Email Subject -->
                <div>
                    <ui-input
                        v-model="form.subject"
                        label="Email Subject"
                        placeholder="Enter email subject line"
                        :error="form.errors.subject"
                        required
                        help="This will be the subject line recipients see"
                    />
                </div>

                <!-- Preview Text -->
                <div>
                    <ui-textarea
                        v-model="form.preview_text"
                        label="Preview Text"
                        placeholder="Enter preview text (optional)"
                        :error="form.errors.preview_text"
                        :rows="2"
                        help="Brief description shown in email clients before opening"
                    />
                </div>

                <!-- Email Content -->
                <div>
                    <ui-rich-text-editor
                        v-model="form.content"
                        label="Email Content"
                        placeholder="Design your email content here..."
                        :error="form.errors.content"
                        :height="500"
                        required
                        help="Use the rich text editor to create your email template with headings, images, links, and more."
                    />
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <ui-button
                        type="submit"
                        :label="submitLabel"
                        variant="primary"
                        :prefix-icon="Save"
                        :loading="form.processing"
                        :disabled="!form.name || !form.subject || !form.content"
                    />
                </div>
            </form>
        </div>

        <!-- Preview Mode - Email Preview Style -->
        <div v-else class="rounded-lg border bg-gray-50 p-6 shadow-sm">
            <div class="mx-auto max-w-2xl">
                <!-- Email Header -->
                <header class="mb-8 border-b border-gray-200 pb-6 text-center">
                    <div class="mb-4">
                        <h1 class="mb-2 text-2xl font-bold text-gray-900">
                            {{ form.name || 'Untitled Template' }}
                        </h1>
                        <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                            <div class="flex items-center">
                                <Calendar class="mr-1 h-4 w-4" />
                                {{ formatDate(new Date().toISOString()) }}
                            </div>
                            <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800"> Draft </span>
                        </div>
                    </div>
                </header>

                <!-- Email Preview -->
                <div class="overflow-hidden rounded-lg bg-white shadow-lg">
                    <!-- Email Client Header Simulation -->
                    <div class="border-b bg-gray-100 px-4 py-3">
                        <div class="flex items-center space-x-2 text-sm">
                            <Mail class="h-4 w-4 text-gray-600" />
                            <span class="font-medium text-gray-900">Subject:</span>
                            <span class="text-gray-700">{{ form.subject || 'No subject' }}</span>
                        </div>
                        <div v-if="form.preview_text" class="mt-1 text-xs text-gray-600">
                            {{ form.preview_text }}
                        </div>
                    </div>

                    <!-- Email Content -->
                    <div class="p-6">
                        <div class="prose prose-sm max-w-none">
                            <div v-if="form.content" v-html="form.content"></div>
                            <div v-else class="text-gray-500 italic">No content yet...</div>
                        </div>
                    </div>
                </div>

                <!-- Save Button in Preview Mode -->
                <div class="mt-6 flex justify-center">
                    <ui-button
                        :label="submitLabel"
                        variant="primary"
                        :prefix-icon="Save"
                        :loading="form.processing"
                        :disabled="!form.name || !form.subject || !form.content"
                        @click="handleSubmit"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
