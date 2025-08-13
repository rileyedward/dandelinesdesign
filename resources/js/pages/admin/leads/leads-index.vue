<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import LeadList from '@/components/lead/lead-list/lead-list.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { Lead } from '@/types/lead';
import { Head } from '@inertiajs/vue3';
import { UserCheck } from 'lucide-vue-next';

defineProps<{
    leads: Lead[];
}>();
</script>

<template>
    <Head title="Leads" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Leads" subtitle="Manage potential customers" :icon="UserCheck" variant="success" />

            <lead-list :leads="leads" />
        </div>
    </sidebar-layout>
</template>
