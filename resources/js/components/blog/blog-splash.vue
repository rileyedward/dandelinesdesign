<script setup lang="ts">
import CommonBackground from '@/components/common/common-background/common-background.vue';
</script>

<template>
    <common-background image-url="/images/background/blog-bg.jpg">
        <div class="blog-widget-card max-w-sm rounded-2xl border border-white/20 bg-white/95 p-8 shadow-2xl backdrop-blur-sm">
            <div class="mb-4 text-center">
                <div class="mx-auto mb-3 h-1 w-16 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500"></div>
                <h3 class="text-2xl font-bold text-gray-900">Dandelines Blog</h3>
            </div>

            <p class="mb-4 text-center text-sm font-medium tracking-wider text-blue-600 uppercase">Insights & Inspiration</p>

            <p class="text-center text-sm leading-relaxed text-gray-700">
                Welcome to the Dandelines Designs blog, where we share creative ideas, event planning tips, and showcase our latest projects. Stay
                inspired with our curated content.
            </p>

            <div class="mt-6 flex justify-center">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-blue-100 to-indigo-200">
                    <svg class="h-4 w-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
            </div>
        </div>
    </common-background>
</template>

<style scoped>
.blog-widget-card {
    position: absolute;
    top: 50%;
    right: 10%;
    transform: translateY(-50%);
    z-index: 20;
}
</style>
