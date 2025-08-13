<script setup lang="ts">
import { BackgroundProps as Props } from '@/components/common/common-background/common-background';

withDefaults(defineProps<Props>(), {
    imageUrl: '/images/placeholder.jpg',
    height: '80vh',
});
</script>

<template>
    <div
        class="relative w-full bg-cover bg-center bg-no-repeat object-cover object-center"
        :style="{
            backgroundImage: `url(${imageUrl})`,
            height: height,
            zIndex: 0,
        }"
    >
        <div class="absolute inset-0" />
        <div class="relative z-10 container mx-auto h-full px-4">
            <slot />
        </div>
    </div>
</template>
