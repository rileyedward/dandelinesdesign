<script setup lang="ts">
import Background from '@/components/background/background.vue';
import Card from '@/components/card/card.vue';
import AppLayout from '@/layouts/app-layout.vue';
</script>

<template>
    <app-layout>
        <background imageUrl="/images/landing-background.jpg">
            <div class="flex h-full items-center justify-center">
                <card :transparent="true">
                    <h1 class="text-4xl font-bold">Welcome to Dandelines Design</h1>
                    <p class="mt-4">This is an example of the new card component with transparency enabled.</p>
                </card>
            </div>
        </background>

        <div class="container mx-auto px-4 py-12">
            <h2 class="mb-6 text-2xl font-semibold">Additional Content</h2>
            <p>This content appears below the background image when scrolling.</p>
        </div>
    </app-layout>
</template>
