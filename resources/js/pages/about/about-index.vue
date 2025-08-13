<script setup lang="ts">
import AboutMe from '@/components/about/about-me.vue';
import AboutSplash from '@/components/about/about-splash.vue';
import AboutTestimonials from '@/components/about/about-testimonials.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import { Testimonial } from '@/types/testimonial';
import { onMounted, ref } from 'vue';

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

        <about-testimonials v-if="testimonials.length" :testimonials="testimonials" />
    </navbar-layout>
</template>
