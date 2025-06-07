<script setup lang="ts">
import { StatMetricProps as Props } from '@/types/components/stat-metric';

defineProps<Props>();
</script>

<template>
    <component :is="href ? 'a' : 'div'" :href="href" class="rounded-lg bg-white p-6 shadow-md transition-all hover:shadow-lg">
        <div
            class="mb-4 flex h-12 w-12 items-center justify-center rounded-full"
            :class="{
                'bg-blue-100 text-blue-600': color === 'blue',
                'bg-green-100 text-green-600': color === 'green',
                'bg-purple-100 text-purple-600': color === 'purple',
                'bg-yellow-100 text-yellow-600': color === 'yellow',
                'bg-pink-100 text-pink-600': color === 'pink',
                'bg-red-100 text-red-600': color === 'red',
                'bg-indigo-100 text-indigo-600': color === 'indigo',
                'bg-gray-100 text-gray-600': color === 'gray',
            }"
        >
            <component :is="icon" class="h-6 w-6" />
        </div>
        <h2 class="text-xl font-semibold text-gray-900">{{ title }}</h2>
        <p class="mt-2 text-gray-600">{{ subtitle }}</p>
    </component>
</template>
