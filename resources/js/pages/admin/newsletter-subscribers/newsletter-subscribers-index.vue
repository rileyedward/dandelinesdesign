<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import NewsletterSubscriberList from '@/components/newsletter-subscriber/newsletter-subscriber-list/newsletter-subscriber-list.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { NewsletterSubscriber } from '@/types/newsletter-subscriber';
import { Head } from '@inertiajs/vue3';
import { Mail } from 'lucide-vue-next';

defineProps<{
    activeSubscribers: NewsletterSubscriber[];
    inactiveSubscribers: NewsletterSubscriber[];
    unsubscribedSubscribers: NewsletterSubscriber[];
}>();
</script>

<template>
    <Head title="Newsletter Subscribers" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header 
                title="Newsletter Subscribers" 
                subtitle="Manage newsletter subscriptions" 
                :icon="Mail" 
                variant="primary" 
            />

            <NewsletterSubscriberList 
                :active-subscribers="activeSubscribers" 
                :inactive-subscribers="inactiveSubscribers"
                :unsubscribed-subscribers="unsubscribedSubscribers"
            />
        </div>
    </sidebar-layout>
</template>