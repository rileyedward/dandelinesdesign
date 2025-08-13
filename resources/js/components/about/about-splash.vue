<script setup lang="ts">
import CommonBackground from '@/components/common/common-background/common-background.vue';
</script>

<template>
    <common-background
        image-url="/images/background/about-bg.jpg"
        :enable-parallax="true"
        :gradient-overlay="true"
        gradient-direction="to-br"
        gradient-from-color="rgba(244, 63, 94, 0.3)"
        gradient-to-color="rgba(236, 72, 153, 0.1)"
    >
        <div
            class="about-widget-card max-w-sm rounded-2xl border border-white/20 bg-white/95 p-8 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:shadow-rose-100/30"
        >
            <div class="mb-4 text-center">
                <div class="mx-auto mb-3 h-1 w-16 rounded-full bg-gradient-to-r from-rose-400 to-pink-500"></div>
                <h3 class="text-2xl font-bold text-gray-900">About Dandelines Designs</h3>
            </div>

            <p class="mb-4 text-center text-sm font-medium tracking-wider text-rose-600 uppercase">Creative Design Event Planning</p>

            <p class="text-center text-sm leading-relaxed text-gray-700">
                At Dandelines Designs, we believe in creating beautiful events that bring your vision to life. We specialize in custom design, and the
                fine details that make your moment special.
            </p>

            <div class="mt-6 flex justify-center">
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-rose-100 to-pink-200 transition-transform duration-500 hover:scale-110"
                >
                    <svg class="h-4 w-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                    </svg>
                </div>
            </div>
        </div>
    </common-background>
</template>

<style scoped>
.about-widget-card {
    position: absolute;
    top: 50%;
    left: 10%;
    transform: translateY(-50%);
    z-index: 20;
}
</style>
