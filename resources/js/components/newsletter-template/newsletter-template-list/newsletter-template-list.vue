<script setup lang="ts">
import NewsletterTemplateBanner from '@/components/newsletter-template/newsletter-template-banner/newsletter-template-banner.vue';
import type { NewsletterTemplateListProps as Props } from './newsletter-template-list';

withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No newsletter templates found',
    loadingText: 'Loading newsletter templates...',
});
</script>

<template>
    <div class="space-y-6">
        <div v-if="loading" class="py-8 text-center text-gray-500">
            {{ loadingText }}
        </div>

        <div v-else-if="newsletterTemplates.length === 0" class="py-8 text-center text-gray-500">
            {{ noDataText }}
        </div>

        <div v-else class="grid grid-cols-1 gap-6">
            <newsletter-template-banner v-for="template in newsletterTemplates" :key="template.id" :template="template" :show-status="true" />
        </div>
    </div>
</template>
