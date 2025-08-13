<script setup lang="ts">
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import { onMounted, ref } from 'vue';
import { Testimonial } from '@/types/testimonial';
import AboutSplash from '@/components/about/about-splash.vue';
import AboutMe from '@/components/about/about-me.vue';

interface Props {
    testimonials: Testimonial[];
}

defineProps<Props>();

const isLoaded = ref<boolean>(false);

onMounted(() => {
    setTimeout(() => {
        isLoaded.value = true;
    }, 300);
});
</script>

<template>
    <navbar-layout>
        <about-splash />

        <about-me />
    </navbar-layout>
</template>

<style scoped>
.about-widget-card {
    position: absolute;
    top: 50%;
    left: 10%;
    transform: translateY(-50%);
    z-index: 20;
}
</style>
