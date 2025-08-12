<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head } from '@inertiajs/vue3';
import { Construction, UserCheck } from 'lucide-vue-next';
</script>

<template>
    <Head title="Lead Details" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Lead Details" subtitle="View lead information" :icon="UserCheck" variant="success" />

            <!-- Under Construction Content -->
            <div class="flex flex-col items-center justify-center py-20">
                <div class="text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-yellow-100">
                        <Construction class="h-10 w-10 text-yellow-600" />
                    </div>

                    <h2 class="mt-6 text-xl font-semibold text-gray-900">Page Under Construction</h2>

                    <p class="mt-2 max-w-md text-sm text-gray-600">This page is being developed. Lead details will be available soon.</p>
                </div>
            </div>
        </div>
    </sidebar-layout>
</template>
