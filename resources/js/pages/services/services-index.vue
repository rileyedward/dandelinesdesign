<script setup lang="ts">
import Background from '@/components/background/background.vue';
import ServiceBannerContainer from '@/components/services/service-banner-container.vue';
import ServicesWidget from '@/components/services/services-widget.vue';
import AppLayout from '@/layouts/app-layout.vue';
</script>

<template>
    <app-layout>
        <background imageUrl="/images/services-background.jpg">
            <div class="flex h-full items-center justify-center">
                <h1 class="text-4xl font-bold text-white">Our Services</h1>
            </div>
            <services-widget />
        </background>

        <div class="container mx-auto px-4 py-12">
            <div class="mx-auto max-w-4xl space-y-8">
                <service-banner-container />
            </div>
        </div>
    </app-layout>
</template>
