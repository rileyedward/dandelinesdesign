<script setup lang="ts">
import CommonBackground from '@/components/common/common-background/common-background.vue';
</script>

<template>
    <common-background image-url="/images/background/services-bg.jpg">
        <div class="services-widget-card max-w-sm rounded-2xl border border-white/20 bg-white/95 p-8 shadow-2xl backdrop-blur-sm">
            <div class="mb-4 text-center">
                <div class="mx-auto mb-3 h-1 w-16 rounded-full bg-gradient-to-r from-amber-400 to-orange-500"></div>
                <h3 class="text-2xl font-bold text-gray-900">Our Services</h3>
            </div>

            <p class="mb-4 text-center text-sm font-medium tracking-wider text-amber-600 uppercase">Exceptional Design & Event Solutions</p>

            <p class="text-center text-sm leading-relaxed text-gray-700">
                From stunning floral arrangements to comprehensive event planning and creative design, we offer a range of services tailored to bring
                your vision to life. Each service is crafted with attention to detail and a commitment to personal and excellent service.
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
.services-widget-card {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 20;
}
</style>
