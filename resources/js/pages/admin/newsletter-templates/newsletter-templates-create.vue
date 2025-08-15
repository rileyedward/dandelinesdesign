<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import NewsletterTemplateForm from '@/components/newsletter-template/newsletter-template-form/newsletter-template-form.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Mail } from 'lucide-vue-next';

const form = useForm({
    name: '',
    subject: '',
    content: '',
    preview_text: '',
});

const handleSubmit = () => {
    form.post(route('admin.newsletter.templates.store'));
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
            <newsletter-template-form
                :form="form"
                submit-label="Save Template"
                @submit="handleSubmit"
            />
        </div>
    </sidebar-layout>
</template>
