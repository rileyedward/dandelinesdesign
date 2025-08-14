<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiRichTextEditor from '@/components/ui/forms/rich-text-editor/ui-rich-text-editor.vue';
import UiSelect from '@/components/ui/forms/select/ui-select.vue';
import UiTextarea from '@/components/ui/forms/textarea/ui-textarea.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Mail, Save } from 'lucide-vue-next';

const form = useForm({
    name: '',
    subject: '',
    content: '',
    preview_text: '',
    status: 'draft',
});

const statusOptions = [
    { label: 'Draft', value: 'draft' },
    { label: 'Scheduled', value: 'scheduled' },
];

const handleSubmit = () => {
    form.post(route('admin.newsletter.templates.store'), {
        onSuccess: () => {
            // Redirect will happen automatically
        },
    });
};

const handleCancel = () => {
    window.history.back();
};
</script>

<template>
    <Head title="Create Newsletter Template" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Create Newsletter Template" subtitle="Design and create a new email template" :icon="Mail" variant="primary">
                <template #actions>
                    <ui-button label="Cancel" variant="outline" size="sm" :prefix-icon="ArrowLeft" @click="handleCancel" />
                </template>
            </common-page-header>

            <!-- Form -->
            <div class="rounded-lg border bg-white p-6 shadow-sm">
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

                    <!-- Status -->
                    <div>
                        <ui-select
                            v-model="form.status"
                            label="Status"
                            :options="statusOptions"
                            :error="form.errors.status"
                            required
                            help="Set to draft to save without sending"
                        />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <ui-button
                            type="submit"
                            :label="form.status === 'draft' ? 'Save Template' : 'Schedule Template'"
                            variant="primary"
                            :prefix-icon="Save"
                            :loading="form.processing"
                            :disabled="!form.name || !form.subject || !form.content"
                        />
                    </div>
                </form>
            </div>
        </div>
    </sidebar-layout>
</template>
