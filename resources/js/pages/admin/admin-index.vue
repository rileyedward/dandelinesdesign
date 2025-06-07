<script setup lang="ts">
import AdminLayout from '@/layouts/admin-layout.vue';
import StatMetric from '@/components/stat-metric/stat-metric.vue';
import { FileText, MessageSquare, Quote, ShoppingBag, Star, Users } from 'lucide-vue-next';
import { AdminIndexPageProps as Props } from '@/types/pages/admin';

defineProps<Props>();
</script>

<template>
    <admin-layout page-title="Dashboard" page-description="Welcome to the Dandelines Design admin panel.">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <stat-metric
                color="indigo"
                :icon="Users"
                :title="`${pageViewsCountShort} visitors in last 7 days`"
                :subtitle="`${pageViewsCountFull} total last month`"
            />

            <stat-metric
                color="green"
                :icon="MessageSquare"
                :title="`${unreadContactMessages} unread messages`"
                :subtitle="`${contactMessagesThisMonth} messages this month`"
                :href="route('admin.contact.index')"
            />

            <stat-metric
                color="yellow"
                :icon="Quote"
                :title="`${unreadQuoteMessages} unread quotes`"
                :subtitle="`${quoteMessagesThisMonth} quotes this month`"
                :href="route('admin.quotes.index')"
            />

            <stat-metric
                color="purple"
                :icon="ShoppingBag"
                title="Products"
                subtitle="Manage your store products"
                :href="route('admin.products.index')"
            />

            <stat-metric color="blue" :icon="FileText" title="Blog Posts" subtitle="Manage your blog content" :href="route('admin.blog.index')" />

            <stat-metric
                color="pink"
                :icon="Star"
                title="Testimonials"
                subtitle="Manage customer testimonials"
                :href="route('admin.testimonials.index')"
            />
        </div>
    </admin-layout>
</template>
