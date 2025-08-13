<script setup lang="ts">
import ServiceBanner from '@/components/services/service-banner.vue';
import ServicesSplash from '@/components/services/services-splash.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import { services } from '@/pages/services/services-index.config';
</script>

<template>
    <navbar-layout>
        <services-splash />

        <div class="container mx-auto px-4 py-12">
            <div class="mx-auto max-w-4xl space-y-8">
                <div v-for="(service, index) in services" :key="index" class="flex" :class="index % 2 === 0 ? 'justify-start' : 'justify-end'">
                    <div class="w-full max-w-3xl">
                        <service-banner :service="service" />
                    </div>
                </div>
            </div>
        </div>
    </navbar-layout>
</template>
