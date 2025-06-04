<script setup lang="ts">
import { ServiceBannerProps as Props } from '@/types/components/service-banner';

defineProps<Props>();
</script>

<template>
    <div class="flex flex-col py-6 md:flex-row" :class="{ 'md:flex-row-reverse': !service.imageOnLeft }">
        <div class="w-full md:w-1/2 bg-black flex items-center justify-center">
            <img :src="service.image_url" alt="Service Image" class="h-auto w-3/5 max-h-72 object-cover aspect-[2/3]" />
        </div>

        <div class="flex w-full flex-col justify-center md:w-1/2" :class="{ 'text-left': service.imageOnLeft, 'text-right': !service.imageOnLeft }">
            <div class="px-8 pt-4">
                <h2 class="mb-1 text-xl font-bold">{{ service.title }}</h2>
            </div>

            <hr class="border-t-2 border-gray-300 w-full" />

            <div class="px-8 pt-3">
                <p class="text-base text-gray-700">{{ service.description }}</p>
            </div>
        </div>
    </div>
</template>
