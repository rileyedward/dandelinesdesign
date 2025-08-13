<script setup lang="ts">
import ServiceBanner from '@/components/services/service-banner.vue';
import ServicesSplash from '@/components/services/services-splash.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import { services } from '@/pages/services/services-index.config';
</script>

<template>
    <navbar-layout>
        <services-splash />

        <div class="bg-gradient-to-b from-slate-50 via-stone-50 to-gray-100 py-20">
            <div class="container mx-auto px-6">
                <div class="mb-16 text-center">
                    <h2 class="mb-4 text-4xl font-bold tracking-tight text-gray-900">Our Services</h2>
                    <div class="mx-auto h-1 w-24 bg-gradient-to-r from-rose-400 to-pink-500"></div>
                    <p class="mt-4 text-lg text-gray-600">Crafting beautiful experiences through design and creativity</p>
                </div>

                <div class="mx-auto max-w-6xl space-y-16">
                    <div v-for="(service, index) in services" :key="index" class="flex justify-center">
                        <div class="w-full max-w-5xl">
                            <service-banner :service="service" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </navbar-layout>
</template>
