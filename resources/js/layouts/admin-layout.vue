<script setup lang="ts">
import { AdminLayoutProps as Props } from '@/types/layouts/admin-layout';
import { Head as InertiaHead } from '@inertiajs/vue3';
import Footer from '@/components/footer/footer.vue';

withDefaults(defineProps<Props>(), {
    pageTitle: 'Dandelines Admin',
});
</script>

<template>
    <inertia-head :title="pageTitle" />

    <main>
        <slot />
    </main>

    <Footer />
</template>
