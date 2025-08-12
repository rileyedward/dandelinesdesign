<script setup lang="ts">
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Construction } from 'lucide-vue-next';
</script>

<template>
    <sidebar-layout>
        <!-- Under Construction Content -->
        <div class="flex flex-col items-center justify-center py-20">
            <div class="text-center">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-yellow-100">
                    <Construction class="h-10 w-10 text-yellow-600" />
                </div>

                <h2 class="mt-6 text-xl font-semibold text-gray-900">Page Under Construction</h2>

                <p class="mt-2 max-w-md text-sm text-gray-600">This page is being developed. Blog post management features will be available soon.</p>
            </div>
        </div>
    </sidebar-layout>
</template>
