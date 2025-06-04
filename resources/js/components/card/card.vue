<script setup lang="ts">
import { CardProps as Props } from '@/types/components/card';

withDefaults(defineProps<Props>(), {
    transparent: false,
});
</script>

<template>
    <div class="rounded-xs bg-white p-4 shadow-md" :class="{ 'bg-opacity-80': transparent }">
        <div class="rounded-xs border-2 border-black p-4">
            <div class="card-content">
                <slot />
            </div>
        </div>
    </div>
</template>
