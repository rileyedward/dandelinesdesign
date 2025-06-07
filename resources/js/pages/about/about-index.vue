<script setup lang="ts">
import AboutSection from '@/components/about/about-section.vue';
import AboutWidget from '@/components/about/about-widget.vue';
import Background from '@/components/background/background.vue';
import TestimonialsSection from '@/components/testimonials/testimonials-section.vue';
import AppLayout from '@/layouts/app-layout.vue';
import { AboutIndexPageProps as Props } from '@/types/pages/about';

defineProps<Props>();
</script>

<template>
    <app-layout>
        <background imageUrl="/images/background/about-bg.jpg">
            <about-widget />
        </background>

        <div class="container mx-auto px-4 py-12">
            <about-section />
        </div>

        <testimonials-section :testimonials="testimonials" />
    </app-layout>
</template>
