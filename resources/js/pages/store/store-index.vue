<script setup lang="ts">
import Background from '@/components/background/background.vue';
import StoreWidget from '@/components/store/store-widget.vue';
import AppLayout from '@/layouts/app-layout.vue';
</script>

<template>
    <app-layout>
        <background imageUrl="/images/store-background.jpg">
            <div class="flex h-full items-center justify-center">
                <h1 class="text-4xl font-bold text-white">Our Store</h1>
            </div>
            <store-widget />
        </background>

        <div class="container mx-auto px-4 py-12">
            <h2 class="mb-6 text-2xl font-semibold">Featured Products</h2>
            <p>This content appears below the background image when scrolling.</p>
        </div>
    </app-layout>
</template>
