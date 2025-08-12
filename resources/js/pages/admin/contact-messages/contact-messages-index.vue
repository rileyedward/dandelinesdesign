<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import ContactMessageList from '@/components/contact-message/contact-message-list/contact-message-list.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head } from '@inertiajs/vue3';
import { Mail } from 'lucide-vue-next';
import { ContactMessage } from '@/types/contact-message';

defineProps<{
    unreadMessages: ContactMessage[];
    readMessages: ContactMessage[];
}>();
</script>

<template>
    <Head title="Contact Messages" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Contact Messages" subtitle="Manage customer inquiries" :icon="Mail" variant="primary" />

            <ContactMessageList :unread-messages="unreadMessages" :read-messages="readMessages" />
        </div>
    </sidebar-layout>
</template>
