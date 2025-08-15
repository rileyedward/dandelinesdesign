<script setup lang="ts">
import NewsletterTemplateBanner from '@/components/newsletter-template/newsletter-template-banner/newsletter-template-banner.vue';
import type { TabItem } from '@/components/ui/navigation/tab/ui-tab';
import UiTab from '@/components/ui/navigation/tab/ui-tab.vue';
import type { NewsletterTemplate } from '@/types/newsletter-template';
import { Edit, Send } from 'lucide-vue-next';
import { ref } from 'vue';
import type { NewsletterTemplateListProps as Props } from './newsletter-template-list';

const props = withDefaults(defineProps<Props>(), {
    draftTemplates: () => [],
    sentTemplates: () => [],
    loading: false,
    noDataText: 'No newsletter templates found',
    loadingText: 'Loading newsletter templates...',
});

const selectedTab = ref('draft');

const tabs: TabItem[] = [
    { label: `Draft (${props.draftTemplates?.length || 0})`, value: 'draft', icon: Edit },
    { label: `Sent (${props.sentTemplates?.length || 0})`, value: 'sent', icon: Send },
];

const handleTemplateClick = (template: NewsletterTemplate) => {
    window.location.href = route('admin.newsletter.templates.show', template.id);
};
</script>

<template>
    <div class="space-y-6">
        <div v-if="loading" class="py-8 text-center text-gray-500">
            {{ loadingText }}
        </div>

        <div v-else>
            <UiTab v-model="selectedTab" :items="tabs" variant="underline">
                <template #default="{ activeTab }">
                    <div v-if="activeTab?.value === 'draft'" class="mt-6 space-y-6">
                        <div v-if="!draftTemplates || draftTemplates.length === 0" class="py-8 text-center text-gray-500">No draft templates</div>

                        <div v-else class="grid grid-cols-1 gap-6">
                            <div v-for="template in draftTemplates" :key="template.id" class="cursor-pointer" @click="handleTemplateClick(template)">
                                <newsletter-template-banner :template="template" :show-status="true" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'sent'" class="mt-6 space-y-6">
                        <div v-if="!sentTemplates || sentTemplates.length === 0" class="py-8 text-center text-gray-500">No sent templates</div>

                        <div v-else class="grid grid-cols-1 gap-6">
                            <div v-for="template in sentTemplates" :key="template.id" class="cursor-pointer" @click="handleTemplateClick(template)">
                                <newsletter-template-banner :template="template" :show-status="true" />
                            </div>
                        </div>
                    </div>
                </template>
            </UiTab>
        </div>
    </div>
</template>
