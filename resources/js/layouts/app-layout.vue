<script setup lang="ts">
import Navbar from '@/components/navbar/navbar.vue';
import { AppLayoutProps as Props } from '@/types/layouts/app-layout';
import { Head as InertiaHead } from '@inertiajs/vue3';

withDefaults(defineProps<Props>(), {
    pageTitle: 'Dandelines Design',
});
</script>

<template>
    <inertia-head :title="pageTitle" />

    <navbar />

    <main>
        <slot />
    </main>
</template>
