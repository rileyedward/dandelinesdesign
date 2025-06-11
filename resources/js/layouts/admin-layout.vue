<script setup lang="ts">
import Sidebar from '@/components/sidebar/sidebar.vue';
import { AdminLayoutProps as Props } from '@/types/layouts/admin-layout';
import { Head as InertiaHead } from '@inertiajs/vue3';

withDefaults(defineProps<Props>(), {
    pageTitle: 'Dandelines Admin',
    pageDescription: '',
});
</script>

<template>
    <inertia-head :title="pageTitle" />

    <Sidebar />

    <div class="min-h-screen bg-gray-50">
        <div class="md:ml-64">
            <main class="container mx-auto px-4 py-12">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">{{ pageTitle }}</h1>
                    <p v-if="pageDescription" class="mt-2 text-lg text-gray-600">{{ pageDescription }}</p>
                </div>

                <slot />
            </main>
        </div>
    </div>
</template>
