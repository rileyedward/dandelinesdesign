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
                <img
                    src="/images/app-logo.png"
                    alt="Dandelines Design Logo"
                    class="h-6 w-6 drop-shadow-md transition-transform duration-500 hover:scale-110"
                />
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
