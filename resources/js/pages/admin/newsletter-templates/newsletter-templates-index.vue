<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import NewsletterTemplateList from '@/components/newsletter-template/newsletter-template-list/newsletter-template-list.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { NewsletterTemplate } from '@/types/newsletter-template';
import { Head } from '@inertiajs/vue3';
import { Mail, Plus } from 'lucide-vue-next';

defineProps<{
    newsletterTemplates: NewsletterTemplate[];
}>();

const handleCreateTemplate = () => {
    window.location.href = route('admin.newsletter.templates.create');
};
</script>

<template>
    <Head title="Newsletter Templates" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Newsletter Templates" subtitle="Manage your email templates" :icon="Mail" variant="primary">
                <template #actions>
                    <ui-button label="Create Template" variant="primary" size="sm" :prefix-icon="Plus" @click="handleCreateTemplate" />
                </template>
            </common-page-header>

            <newsletter-template-list :newsletter-templates="newsletterTemplates" />
        </div>
    </sidebar-layout>
</template>
