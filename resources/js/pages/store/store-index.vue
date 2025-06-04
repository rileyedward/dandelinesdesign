<script setup lang="ts">
import Background from '@/components/background/background.vue';
import StoreWidget from '@/components/store/store-widget.vue';
import AppLayout from '@/layouts/app-layout.vue';
</script>

<template>
    <app-layout>
        <background imageUrl="/images/store-background.jpg">
            <store-widget />
        </background>

        <div class="container mx-auto px-4 py-12">
            <h2 class="mb-6 text-2xl font-semibold">Featured Products</h2>
            <p>This content appears below the background image when scrolling.</p>
        </div>
    </app-layout>
</template>
