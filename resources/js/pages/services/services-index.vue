<script setup lang="ts">
import Background from '@/components/background/background.vue';
import ServiceBanner from '@/components/services/service-banner.vue';
import ServicesWidget from '@/components/services/services-widget.vue';
import AppLayout from '@/layouts/app-layout.vue';
import { services } from './services.config';
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
                <div v-for="(service, index) in services" :key="index" class="flex" :class="index % 2 === 0 ? 'justify-start' : 'justify-end'">
                    <div class="w-full max-w-3xl">
                        <service-banner :service="service" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
