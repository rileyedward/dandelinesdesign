<script setup lang="ts">
import AdminLayout from '@/layouts/admin-layout.vue';
import StatMetric from '@/components/stat-metric/stat-metric.vue';
import { FileText, MessageSquare, Quote, ShoppingBag, Star, Users } from 'lucide-vue-next';
</script>

<template>
    <admin-layout page-title="Dashboard" page-description="Welcome to the Dandelines Design admin panel.">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <stat-metric
                color="green"
                :icon="MessageSquare"
                title="Contact Messages"
                subtitle="View and respond to messages"
                :href="route('admin.contact.index')"
            />

            <stat-metric
                color="yellow"
                :icon="Quote"
                title="Quotes"
                subtitle="Manage customer quotes"
                :href="route('admin.quotes.index')"
            />

            <stat-metric
                color="purple"
                :icon="ShoppingBag"
                title="Products"
                subtitle="Manage your store products"
                :href="route('admin.products.index')"
            />

            <stat-metric
                color="blue"
                :icon="FileText"
                title="Blog Posts"
                subtitle="Manage your blog content"
                :href="route('admin.blog.index')"
            />

            <stat-metric
                color="pink"
                :icon="Star"
                title="Testimonials"
                subtitle="Manage customer testimonials"
                :href="route('admin.testimonials.index')"
            />

            <stat-metric
                color="indigo"
                :icon="Users"
                title="Page Views"
                subtitle="Track website visitors"
            />
        </div>
    </admin-layout>
</template>
