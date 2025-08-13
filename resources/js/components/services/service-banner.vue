<script setup lang="ts">
import { ServiceBanner } from '@/pages/services/services-index.config';

interface Props {
    service: ServiceBanner;
}

defineProps<Props>();
</script>

<template>
    <div class="group hover:shadow-3xl relative overflow-hidden rounded-3xl bg-white shadow-2xl transition-all duration-500">
        <div class="flex flex-col lg:flex-row" :class="{ 'lg:flex-row-reverse': !service.imageOnLeft }">
            <div class="relative w-full lg:w-2/5">
                <div class="aspect-square overflow-hidden lg:aspect-[4/5]">
                    <img
                        :src="service.image_url"
                        alt="Service Image"
                        class="h-full w-full object-cover object-center transition-transform duration-700 group-hover:scale-110"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                    ></div>
                </div>

                <div
                    class="absolute -bottom-6 h-12 w-12 rounded-full bg-gradient-to-br opacity-60 transition-transform duration-500 group-hover:scale-125"
                    :class="{
                        '-right-6 from-rose-400 to-pink-500': service.imageOnLeft,
                        '-left-6 from-amber-400 to-orange-500': !service.imageOnLeft,
                    }"
                ></div>
            </div>

            <div
                class="flex w-full flex-col justify-center px-8 py-12 lg:w-3/5 lg:px-12"
                :class="{ 'text-left': service.imageOnLeft, 'text-right': !service.imageOnLeft }"
            >
                <div class="relative">
                    <div
                        class="absolute -top-4 h-1 w-16 bg-gradient-to-r transition-all duration-500 group-hover:w-24"
                        :class="{
                            'left-0 from-rose-400 to-pink-500': service.imageOnLeft,
                            'right-0 from-amber-400 to-orange-500': !service.imageOnLeft,
                        }"
                    ></div>

                    <h2 class="mb-6 text-3xl font-bold text-gray-900 transition-colors duration-300 group-hover:text-gray-700 lg:text-4xl">
                        {{ service.title }}
                    </h2>

                    <div class="mb-6 space-y-4">
                        <p class="text-lg leading-relaxed text-gray-700 transition-colors duration-300 group-hover:text-gray-600">
                            {{ service.description }}
                        </p>
                    </div>

                    <a href="#" class="flex gap-3" :class="{ 'justify-start': service.imageOnLeft, 'justify-end': !service.imageOnLeft }">
                        <div
                            class="inline-flex items-center rounded-full px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:scale-105 hover:shadow-lg"
                            :class="{
                                'bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700': service.imageOnLeft,
                                'bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700': !service.imageOnLeft,
                            }"
                        >
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                />
                            </svg>
                            Let's Discuss Your Vision
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div
            class="absolute h-full w-1 bg-gradient-to-b transition-all duration-500 group-hover:w-2"
            :class="{
                'top-0 left-0 from-rose-400 to-pink-500': service.imageOnLeft,
                'top-0 right-0 from-amber-400 to-orange-500': !service.imageOnLeft,
            }"
        ></div>
    </div>
</template>
