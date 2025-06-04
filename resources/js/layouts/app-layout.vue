<script setup lang="ts">
import { AppLayoutProps as Props } from '@/types/layouts/app-layout';
import { Head as InertiaHead } from '@inertiajs/vue3';

withDefaults(defineProps<Props>(), {
    pageTitle: 'Dandelines Design',
});
</script>

<template>
    <inertia-head :title="pageTitle" />

    <slot />
</template>
