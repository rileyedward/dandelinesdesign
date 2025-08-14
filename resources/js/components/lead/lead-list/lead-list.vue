<script setup lang="ts">
import LeadBanner from '@/components/lead/lead-banner/lead-banner.vue';
import type { TabItem } from '@/components/ui/navigation/tab/ui-tab';
import UiTab from '@/components/ui/navigation/tab/ui-tab.vue';
import type { Lead } from '@/types/lead';
import { Award, ContactIcon, FileCheck, Star, UserPlus, XCircle } from 'lucide-vue-next';
import { ref } from 'vue';
import type { LeadListProps as Props } from './lead-list';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No leads found',
    loadingText: 'Loading leads...',
});

const selectedTab = ref('new');

const tabs: TabItem[] = [
    { label: `New (${props.newLeads.length})`, value: 'new', icon: UserPlus },
    { label: `Contacted (${props.contactedLeads.length})`, value: 'contacted', icon: ContactIcon },
    { label: `Qualified (${props.qualifiedLeads.length})`, value: 'qualified', icon: Star },
    { label: `Proposal (${props.proposalLeads.length})`, value: 'proposal', icon: FileCheck },
    { label: `Won (${props.wonLeads.length})`, value: 'won', icon: Award },
    { label: `Lost (${props.lostLeads.length})`, value: 'lost', icon: XCircle },
];

const handleLeadClick = (lead: Lead) => {
    window.location.href = `/admin/leads/${lead.id}`;
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
                    <div v-if="activeTab?.value === 'new'" class="mt-6 space-y-6">
                        <div v-if="newLeads.length === 0" class="py-8 text-center text-gray-500">No new leads</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div v-for="lead in newLeads" :key="lead.id" class="cursor-pointer" @click="handleLeadClick(lead)">
                                <lead-banner :lead="lead" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'contacted'" class="mt-6 space-y-6">
                        <div v-if="contactedLeads.length === 0" class="py-8 text-center text-gray-500">No contacted leads</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div v-for="lead in contactedLeads" :key="lead.id" class="cursor-pointer" @click="handleLeadClick(lead)">
                                <lead-banner :lead="lead" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'qualified'" class="mt-6 space-y-6">
                        <div v-if="qualifiedLeads.length === 0" class="py-8 text-center text-gray-500">No qualified leads</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div v-for="lead in qualifiedLeads" :key="lead.id" class="cursor-pointer" @click="handleLeadClick(lead)">
                                <lead-banner :lead="lead" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'proposal'" class="mt-6 space-y-6">
                        <div v-if="proposalLeads.length === 0" class="py-8 text-center text-gray-500">No proposal leads</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div v-for="lead in proposalLeads" :key="lead.id" class="cursor-pointer" @click="handleLeadClick(lead)">
                                <lead-banner :lead="lead" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'won'" class="mt-6 space-y-6">
                        <div v-if="wonLeads.length === 0" class="py-8 text-center text-gray-500">No won leads</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div v-for="lead in wonLeads" :key="lead.id" class="cursor-pointer" @click="handleLeadClick(lead)">
                                <lead-banner :lead="lead" />
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab?.value === 'lost'" class="mt-6 space-y-6">
                        <div v-if="lostLeads.length === 0" class="py-8 text-center text-gray-500">No lost leads</div>

                        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div v-for="lead in lostLeads" :key="lead.id" class="cursor-pointer" @click="handleLeadClick(lead)">
                                <lead-banner :lead="lead" />
                            </div>
                        </div>
                    </div>
                </template>
            </UiTab>
        </div>
    </div>
</template>
