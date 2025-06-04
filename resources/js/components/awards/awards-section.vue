<script setup lang="ts">
import { awards, awardsDisplayConfig } from '@/components/awards/awards-section.config';
</script>

<template>
    <div class="w-full bg-white py-12">
        <div class="container mx-auto px-4">
            <h2 class="mb-8 text-center text-3xl font-bold">Awards & Recognition</h2>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="(award, index) in awards.slice(0, awardsDisplayConfig.maxDisplay)"
                    :key="index"
                    class="rounded-lg bg-gray-50 p-6 shadow-sm transition-shadow duration-300 hover:shadow-md"
                >
                    <h3 class="mb-2 text-center text-xl font-semibold">{{ award.title }}</h3>

                    <div class="mb-3 text-center text-gray-600">
                        <span class="font-medium">{{ award.organization }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ award.year }}</span>
                    </div>

                    <p class="text-center text-gray-700">{{ award.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
