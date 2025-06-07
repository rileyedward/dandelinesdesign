<script setup lang="ts">
import { AdminLayoutProps as Props } from '@/types/layouts/admin-layout';
import { Head as InertiaHead } from '@inertiajs/vue3';
import Footer from '@/components/footer/footer.vue';
import Sidebar from '@/components/sidebar/sidebar.vue';

withDefaults(defineProps<Props>(), {
    pageTitle: 'Dandelines Admin',
});
</script>

<template>
    <inertia-head :title="pageTitle" />

    <Sidebar />

    <div class="min-h-screen bg-gray-50">
        <div class="md:ml-64">
            <main class="container mx-auto px-4 py-12">
                <slot />
            </main>

            <Footer />
        </div>
    </div>
</template>
