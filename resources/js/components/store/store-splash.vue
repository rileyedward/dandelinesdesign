<script setup lang="ts">
import CommonBackground from '@/components/common/common-background/common-background.vue';
</script>

<template>
    <common-background
        image-url="/images/background/store-bg.png"
        :enable-parallax="true"
        :gradient-overlay="true"
        gradient-direction="to-t"
        gradient-from-color="rgba(180, 83, 9, 0.4)"
        gradient-to-color="rgba(251, 191, 36, 0.1)"
        height="85vh"
    >
        <div
            class="store-widget-card max-w-sm rounded-2xl border border-white/20 bg-white/95 p-8 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:translate-y-[-5px] hover:shadow-amber-100/30"
        >
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
.store-widget-card {
    position: absolute;
    top: 50%;
    left: 10%;
    transform: translateY(-50%);
    z-index: 20;
}
</style>
