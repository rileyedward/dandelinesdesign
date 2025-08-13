<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import QuoteRequestList from '@/components/quote-request/quote-request-list/quote-request-list.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { QuoteRequest } from '@/types/quote-request';
import { Head } from '@inertiajs/vue3';
import { MessageSquare } from 'lucide-vue-next';

defineProps<{
    pendingRequests: QuoteRequest[];
    contactedRequests: QuoteRequest[];
    quotedRequests: QuoteRequest[];
    completedRequests: QuoteRequest[];
    cancelledRequests: QuoteRequest[];
}>();
</script>

<template>
    <Head title="Quote Requests" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Quote Requests" subtitle="Manage customer quote requests" :icon="MessageSquare" variant="info" />

            <QuoteRequestList
                :pending-requests="pendingRequests"
                :contacted-requests="contactedRequests"
                :quoted-requests="quotedRequests"
                :completed-requests="completedRequests"
                :cancelled-requests="cancelledRequests"
            />
        </div>
    </sidebar-layout>
</template>
