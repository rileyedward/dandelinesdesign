<script setup lang="ts">
import AboutSection from '@/components/about-section.vue';
import AboutWidget from '@/components/about-widget.vue';
import Background from '@/components/background/background.vue';
import TestimonialsSection from '@/components/testimonials-section.vue';
import AppLayout from '@/layouts/app-layout.vue';
</script>

<template>
    <app-layout>
        <background imageUrl="/images/about-background.jpg">
            <div class="flex h-full items-center justify-center">
                <h1 class="text-4xl font-bold text-white">About Us</h1>
            </div>
            <about-widget />
        </background>

        <div class="container mx-auto px-4 py-12">
            <about-section />
        </div>

        <testimonials-section />
    </app-layout>
</template>
