<script setup lang="ts">
import AboutSection from '@/components/about/about-section.vue';
import AboutWidget from '@/components/about/about-widget.vue';
import AwardsSection from '@/components/awards/awards-section.vue';
import Background from '@/components/background/background.vue';
import TestimonialsSection from '@/components/testimonials/testimonials-section.vue';
import AppLayout from '@/layouts/app-layout.vue';
</script>

<template>
    <app-layout>
        <background imageUrl="/images/about-background.jpg">
            <about-widget />
        </background>

        <div class="container mx-auto px-4 py-12">
            <about-section />
        </div>

        <testimonials-section />

        <awards-section />
    </app-layout>
</template>
