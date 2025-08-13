<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import LeadInfo from '@/components/lead/lead-info/lead-info.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { Lead } from '@/types/lead';
import { Head } from '@inertiajs/vue3';
import { UserCheck } from 'lucide-vue-next';

defineProps<{
    lead: Lead;
}>();

const handleLeadUpdated = () => {
    window.location.reload();
};
</script>

<template>
    <Head title="Lead Details" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Lead Details" subtitle="View lead information" :icon="UserCheck" variant="success" />

            <lead-info :lead="lead" @updated="handleLeadUpdated" />
        </div>
    </sidebar-layout>
</template>
