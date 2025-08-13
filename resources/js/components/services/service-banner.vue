<script setup lang="ts">
import { ServiceBanner } from '@/pages/services/services-index.config';

interface Props {
    service: ServiceBanner;
}

defineProps<Props>();
</script>

<template>
    <div class="flex flex-col py-6 md:flex-row" :class="{ 'md:flex-row-reverse': !service.imageOnLeft }">
        <div class="w-full bg-white p-4 md:w-2/5">
            <div class="h-90 border-2 border-black p-2">
                <img :src="service.image_url" alt="Service Image" class="h-full w-full object-cover object-center" />
            </div>
        </div>

        <div class="flex w-full flex-col justify-center md:w-3/5" :class="{ 'text-left': service.imageOnLeft, 'text-right': !service.imageOnLeft }">
            <div class="px-8 pt-4">
                <h2 class="mb-1 text-xl font-bold">{{ service.title }}</h2>
            </div>

            <hr class="w-full border-t-2 border-gray-300" />

            <div class="px-8 pt-3">
                <p class="text-base text-gray-700">{{ service.description }}</p>
            </div>
        </div>
    </div>
</template>
