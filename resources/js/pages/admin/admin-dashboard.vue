<script setup lang="ts">
import adminConfig from '@/layouts/sidebar/admin-sidebar-layout.config';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head } from '@inertiajs/vue3';
import { Construction } from 'lucide-vue-next';
</script>

<template>
    <Head title="Admin Dashboard" />

    <sidebar-layout :config="adminConfig">
        <div class="flex flex-col items-center justify-center py-20">
            <div class="text-center">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-yellow-100">
                    <Construction class="h-10 w-10 text-yellow-600" />
                </div>

                <h2 class="mt-6 text-xl font-semibold text-gray-900">Dashboard Under Construction</h2>

                <p class="mt-2 max-w-md text-sm text-gray-600">
                    We're building something beautiful! The admin dashboard is currently being developed. Use the sidebar navigation to access the
                    management sections for your business.
                </p>
            </div>
        </div>
    </sidebar-layout>
</template>
