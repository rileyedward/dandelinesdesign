<script setup lang="ts">
import { BackgroundProps as Props } from '@/types/components/background';

withDefaults(defineProps<Props>(), {
    imageUrl: '/images/placeholder.jpg',
    height: '80vh',
});
</script>

<template>
    <div
        class="relative w-full bg-cover bg-center bg-no-repeat"
        :style="{
            backgroundImage: `url(${imageUrl})`,
            height: height,
        }"
    >
        <div class="bg-opacity-40 absolute inset-0 bg-zinc-300" />
        <div class="relative z-10 container mx-auto h-full px-4">
            <slot />
        </div>
    </div>
</template>
