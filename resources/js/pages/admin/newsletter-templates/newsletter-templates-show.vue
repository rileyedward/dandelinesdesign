<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiRichTextEditor from '@/components/ui/forms/rich-text-editor/ui-rich-text-editor.vue';
import UiSelect from '@/components/ui/forms/select/ui-select.vue';
import UiTextarea from '@/components/ui/forms/textarea/ui-textarea.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { NewsletterTemplate } from '@/types/newsletter-template';
import { Head, useForm } from '@inertiajs/vue3';
import { Calendar, Edit, Eye, Mail, Save, Send, Trash2, Users } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    newsletterTemplate: NewsletterTemplate;
}>();

const isEditing = ref(false);

const form = useForm({
    name: props.newsletterTemplate.name,
    subject: props.newsletterTemplate.subject,
    content: props.newsletterTemplate.content,
    preview_text: props.newsletterTemplate.preview_text || '',
    status: props.newsletterTemplate.status,
});

const statusOptions = [
    { label: 'Draft', value: 'draft' },
    { label: 'Scheduled', value: 'scheduled' },
    { label: 'Sent', value: 'sent' },
];

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const getStatusColor = (status: string) => {
    switch (status) {
        case 'sent':
            return 'bg-green-100 text-green-800';
        case 'scheduled':
            return 'bg-blue-100 text-blue-800';
        case 'draft':
            return 'bg-yellow-100 text-yellow-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const getEngagementRate = () => {
    if (props.newsletterTemplate.recipients_count === 0) return 0;
    return Math.round((props.newsletterTemplate.opens_count / props.newsletterTemplate.recipients_count) * 100);
};

const getClickRate = () => {
    if (props.newsletterTemplate.recipients_count === 0) return 0;
    return Math.round((props.newsletterTemplate.clicks_count / props.newsletterTemplate.recipients_count) * 100);
};

const toggleEdit = () => {
    isEditing.value = !isEditing.value;
};

const handleSubmit = () => {
    form.patch(route('admin.newsletter.templates.update', props.newsletterTemplate.id), {
        onSuccess: () => {
            isEditing.value = false;
        },
    });
};

const handleDelete = () => {
    if (confirm('Are you sure you want to delete this newsletter template? This action cannot be undone.')) {
        form.delete(route('admin.newsletter.templates.destroy', props.newsletterTemplate.id));
    }
};
</script>

<template>
    <Head :title="newsletterTemplate.name" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header
                :title="isEditing ? `Edit: ${newsletterTemplate.name}` : newsletterTemplate.name"
                :subtitle="isEditing ? 'Update template content and settings' : 'Newsletter template preview'"
                :icon="Mail"
                variant="primary"
            >
                <template #actions>
                    <div class="flex space-x-2">
                        <ui-button v-if="!isEditing" label="Edit Template" variant="primary" size="sm" :prefix-icon="Edit" @click="toggleEdit" />
                        <ui-button v-if="isEditing" label="Delete" variant="destructive" size="sm" :prefix-icon="Trash2" @click="handleDelete" />
                        <ui-button v-if="isEditing" label="Preview" variant="secondary" size="sm" :prefix-icon="Eye" @click="toggleEdit" />
                    </div>
                </template>
            </common-page-header>

            <!-- Template Analytics (for sent templates) -->
            <div v-if="!isEditing && newsletterTemplate.status === 'sent' && newsletterTemplate.recipients_count > 0" 
                 class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <div class="rounded-lg border bg-white p-4 shadow-sm">
                    <div class="flex items-center">
                        <Users class="h-8 w-8 text-blue-600" />
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Recipients</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ newsletterTemplate.recipients_count.toLocaleString() }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border bg-white p-4 shadow-sm">
                    <div class="flex items-center">
                        <Eye class="h-8 w-8 text-green-600" />
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Opens</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ newsletterTemplate.opens_count.toLocaleString() }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border bg-white p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="text-sm font-medium text-green-800">{{ getEngagementRate() }}%</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Open Rate</p>
                            <p class="text-lg font-semibold text-gray-900">{{ getEngagementRate() }}%</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border bg-white p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-sm font-medium text-blue-800">{{ getClickRate() }}%</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Click Rate</p>
                            <p class="text-lg font-semibold text-gray-900">{{ getClickRate() }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div v-if="isEditing" class="rounded-lg border bg-white p-6 shadow-sm">
                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <!-- Template Name -->
                    <div>
                        <ui-input
                            v-model="form.name"
                            label="Template Name"
                            placeholder="Enter template name"
                            :error="form.errors.name"
                            required
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
                        />
                    </div>

                    <!-- Status -->
                    <div>
                        <ui-select
                            v-model="form.status"
                            label="Status"
                            :options="statusOptions"
                            :error="form.errors.status"
                            required
                        />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <ui-button
                            type="submit"
                            label="Update Template"
                            variant="primary"
                            :prefix-icon="Save"
                            :loading="form.processing"
                            :disabled="!form.name || !form.subject || !form.content"
                        />
                    </div>
                </form>
            </div>

            <!-- Email Preview Mode -->
            <div v-else class="rounded-lg border bg-gray-50 p-6 shadow-sm">
                <div class="mx-auto max-w-2xl">
                    <!-- Email Header -->
                    <header class="mb-8 text-center border-b border-gray-200 pb-6">
                        <div class="mb-4">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                                {{ newsletterTemplate.name }}
                            </h1>
                            <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <Calendar class="mr-1 h-4 w-4" />
                                    Created {{ formatDate(newsletterTemplate.created_at) }}
                                </div>
                                <span :class="['px-2 py-1 rounded-full text-xs font-medium', getStatusColor(newsletterTemplate.status)]">
                                    {{ newsletterTemplate.status }}
                                </span>
                            </div>
                        </div>
                    </header>

                    <!-- Email Preview -->
                    <div class="rounded-lg bg-white shadow-lg overflow-hidden">
                        <!-- Email Client Header Simulation -->
                        <div class="bg-gray-100 px-4 py-3 border-b">
                            <div class="flex items-center space-x-2 text-sm">
                                <Mail class="h-4 w-4 text-gray-600" />
                                <span class="font-medium text-gray-900">Subject:</span>
                                <span class="text-gray-700">{{ newsletterTemplate.subject }}</span>
                            </div>
                            <div v-if="newsletterTemplate.preview_text" class="mt-1 text-xs text-gray-600">
                                {{ newsletterTemplate.preview_text }}
                            </div>
                        </div>

                        <!-- Email Content -->
                        <div class="p-6">
                            <div class="prose prose-sm max-w-none">
                                <div v-html="newsletterTemplate.content"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Template Details -->
                    <footer class="mt-8 text-center">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div v-if="newsletterTemplate.sent_at" class="flex items-center justify-center">
                                <Send class="mr-1 h-4 w-4" />
                                Sent {{ formatDate(newsletterTemplate.sent_at) }}
                            </div>
                            <div v-else-if="newsletterTemplate.scheduled_at" class="flex items-center justify-center">
                                <Calendar class="mr-1 h-4 w-4" />
                                Scheduled {{ formatDate(newsletterTemplate.scheduled_at) }}
                            </div>
                            <div v-if="newsletterTemplate.updated_at !== newsletterTemplate.created_at" class="flex items-center justify-center">
                                <Edit class="mr-1 h-4 w-4" />
                                Updated {{ formatDate(newsletterTemplate.updated_at) }}
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </sidebar-layout>
</template>