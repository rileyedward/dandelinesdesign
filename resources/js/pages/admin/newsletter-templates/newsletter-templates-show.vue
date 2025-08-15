<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import NewsletterTemplateForm from '@/components/newsletter-template/newsletter-template-form/newsletter-template-form.vue';
import NewsletterTemplateSend from '@/components/newsletter-template/newsletter-template-send/newsletter-template-send.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { NewsletterTemplate } from '@/types/newsletter-template';
import { Head, useForm } from '@inertiajs/vue3';
import { Calendar, Edit, Eye, Mail, Send, Trash2, Users } from 'lucide-vue-next';
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
});

const deleteForm = useForm({});
const sendForm = useForm({});
const sendComponentRef = ref();

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

const handleSend = () => {
    sendForm.post(route('admin.newsletter.templates.send', props.newsletterTemplate.id), {
        onSuccess: () => {
            if (sendComponentRef.value) {
                sendComponentRef.value.handleSuccess();
            }
        },
    });
};

const handleDelete = () => {
    if (confirm('Are you sure you want to delete this newsletter template? This action cannot be undone.')) {
        deleteForm.delete(route('admin.newsletter.templates.destroy', props.newsletterTemplate.id));
    }
};
</script>

<template>
    <Head :title="newsletterTemplate.name" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header
                :title="isEditing ? `Edit: ${newsletterTemplate.name}` : newsletterTemplate.name"
                :subtitle="isEditing ? 'Update newsletter template content and settings' : 'Newsletter template preview'"
                :icon="Mail"
                variant="primary"
            >
                <template #actions>
                    <div class="flex space-x-2">
                        <ui-button v-if="!isEditing" label="Edit Template" variant="primary" size="sm" :prefix-icon="Edit" @click="toggleEdit" />
                        <ui-button v-if="isEditing" label="Delete" variant="destructive" size="sm" :prefix-icon="Trash2" @click="handleDelete" />
                        <ui-button v-if="isEditing" label="View Template" variant="secondary" size="sm" :prefix-icon="Eye" @click="toggleEdit" />
                    </div>
                </template>
            </common-page-header>

            <!-- Edit Form -->
            <newsletter-template-form
                v-if="isEditing"
                :form="form"
                submit-label="Update Template"
                :is-editing="true"
                @submit="handleSubmit"
            />

            <!-- Send Newsletter Component -->
            <newsletter-template-send
                v-if="!isEditing"
                ref="sendComponentRef"
                :newsletter-template="newsletterTemplate"
                :form="sendForm"
                @send="handleSend"
            />

            <!-- Template Analytics (for sent templates) -->
            <div v-if="newsletterTemplate.status === 'sent' && newsletterTemplate.recipients_count > 0" class="grid grid-cols-1 gap-4 sm:grid-cols-4">
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
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
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
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
                            <span class="text-sm font-medium text-blue-800">{{ getClickRate() }}%</span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Click Rate</p>
                            <p class="text-lg font-semibold text-gray-900">{{ getClickRate() }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Preview -->
            <div class="rounded-lg border bg-gray-50 p-6 shadow-sm">
                <div class="mx-auto max-w-2xl">
                    <!-- Email Header -->
                    <header class="mb-8 border-b border-gray-200 pb-6 text-center">
                        <div class="mb-4">
                            <h1 class="mb-2 text-2xl font-bold text-gray-900">
                                {{ newsletterTemplate.name }}
                            </h1>
                            <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <Calendar class="mr-1 h-4 w-4" />
                                    Created {{ formatDate(newsletterTemplate.created_at) }}
                                </div>
                                <span :class="['rounded-full px-2 py-1 text-xs font-medium', getStatusColor(newsletterTemplate.status)]">
                                    {{ newsletterTemplate.status }}
                                </span>
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
                        <div class="grid grid-cols-1 gap-4 text-sm text-gray-600 sm:grid-cols-2">
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
