<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Calendar, Mail, Send, Users } from 'lucide-vue-next';
import type { NewsletterTemplateBannerProps as Props } from './newsletter-template-banner';

const { template } = withDefaults(defineProps<Props>(), {
    showStatus: true,
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const getStatusClasses = (status: string) => {
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

const getStatusLabel = (status: string) => {
    switch (status) {
        case 'sent':
            return 'Sent';
        case 'scheduled':
            return 'Scheduled';
        case 'draft':
            return 'Draft';
        default:
            return status;
    }
};

const handleView = () => {
    router.visit(route('admin.newsletter.templates.show', template.id));
};
</script>

<template>
    <div
        class="cursor-pointer rounded-lg border border-gray-200 bg-white p-6 shadow-md transition-all duration-300 hover:border-blue-300 hover:shadow-lg"
        @click="handleView"
    >
        <div class="mb-4 flex items-start justify-between">
            <div class="flex-1">
                <h3 class="mb-1 text-lg font-semibold text-gray-900">{{ template.name }}</h3>
                <p class="flex items-center text-sm text-gray-600">
                    <Mail class="mr-1 h-3 w-3" />
                    Subject: <span class="ml-1 font-medium">{{ template.subject }}</span>
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <div v-if="showStatus" :class="['rounded-full px-2 py-1 text-xs font-medium', getStatusClasses(template.status)]">
                    {{ getStatusLabel(template.status) }}
                </div>
            </div>
        </div>

        <!-- Analytics for sent templates -->
        <div v-if="template.status === 'sent' && template.recipients_count > 0" class="mb-4 grid grid-cols-3 gap-4 rounded-lg bg-gray-50 p-3">
            <div class="text-center">
                <div class="flex items-center justify-center text-sm text-gray-600">
                    <Users class="mr-1 h-4 w-4" />
                    Recipients
                </div>
                <div class="font-semibold text-gray-900">{{ template.recipients_count.toLocaleString() }}</div>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-500">
                <Calendar class="mr-1 h-4 w-4" />
                Created {{ formatDate(template.created_at) }}
                <span v-if="template.sent_at" class="ml-2 flex items-center">
                    <Send class="mr-1 h-3 w-3" />
                    Sent {{ formatDate(template.sent_at) }}
                </span>
            </div>
        </div>
    </div>
</template>
