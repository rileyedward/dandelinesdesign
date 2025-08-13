<script setup lang="ts">
import CommonBackground from '@/components/common/common-background/common-background.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
</script>

<template>
    <navbar-layout>
        <common-background image-url="/images/background/services-bg.jpg">
            <div class="services-widget-card max-w-sm rounded-lg bg-white p-6 shadow-md">
                <h3 class="mb-2 text-center text-xl font-semibold">Our Services</h3>

                <p class="mb-3 text-center text-sm text-gray-600 italic">Exceptional Design & Event Solutions</p>

                <hr class="mx-auto mb-3 w-16 border-t border-gray-300" />

                <p class="text-center text-sm text-gray-700">
                    From stunning floral arrangements to comprehensive event planning and creative design, we offer a range of services tailored to
                    bring your vision to life. Each service is crafted with attention to detail and a commitment personal and excellent service.
                </p>
            </div>
        </common-background>

        <div class="container mx-auto px-4 py-12">
            <div class="mx-auto max-w-4xl space-y-8">
                <!-- TODO: Service Banner Container -->
            </div>
        </div>
    </navbar-layout>
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
