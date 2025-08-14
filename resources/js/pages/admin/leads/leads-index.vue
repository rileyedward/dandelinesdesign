<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import LeadCreateDrawer from '@/components/lead/lead-create-drawer/lead-create-drawer.vue';
import LeadList from '@/components/lead/lead-list/lead-list.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { Lead } from '@/types/lead';
import { Head } from '@inertiajs/vue3';
import { UserCheck } from 'lucide-vue-next';

defineProps<{
    newLeads: Lead[];
    contactedLeads: Lead[];
    qualifiedLeads: Lead[];
    proposalLeads: Lead[];
    wonLeads: Lead[];
    lostLeads: Lead[];
}>();

const handleLeadCreated = () => {
    window.location.reload();
};
</script>

<template>
    <Head title="Leads" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Leads" subtitle="Manage potential customers" :icon="UserCheck" variant="success">
                <template #actions>
                    <lead-create-drawer @created="handleLeadCreated" />
                </template>
            </common-page-header>

            <lead-list
                :new-leads="newLeads"
                :contacted-leads="contactedLeads"
                :qualified-leads="qualifiedLeads"
                :proposal-leads="proposalLeads"
                :won-leads="wonLeads"
                :lost-leads="lostLeads"
            />
        </div>
    </sidebar-layout>
</template>
