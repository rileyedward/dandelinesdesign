<script setup lang="ts">
import CommonBackground from '@/components/common/common-background/common-background.vue';
</script>

<template>
    <common-background image-url="/images/background/store-bg.png">
        <div class="store-widget-card max-w-sm rounded-2xl border border-white/20 bg-white/95 p-8 shadow-2xl backdrop-blur-sm">
            <div class="mb-4 text-center">
                <div class="mx-auto mb-3 h-1 w-16 rounded-full bg-gradient-to-r from-amber-400 to-orange-500"></div>
                <h3 class="text-2xl font-bold text-gray-900">Dandelines Store</h3>
            </div>

            <p class="mb-4 text-center text-sm font-medium tracking-wider text-amber-600 uppercase">Handcrafted Designs</p>

            <p class="text-center text-sm leading-relaxed text-gray-700">
                Discover our collection of handcrafted designs and event essentials. Each item is carefully created to bring beauty and elegance to
                your special moments.
            </p>

            <div class="mt-6 flex justify-center">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-amber-100 to-orange-200">
                    <svg class="h-4 w-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                        />
                    </svg>
                </div>
            </div>
        </div>
    </common-background>
</template>

<style scoped>
.store-widget-card {
    position: absolute;
    top: 50%;
    left: 10%;
    transform: translateY(-50%);
    z-index: 20;
}
</style>
