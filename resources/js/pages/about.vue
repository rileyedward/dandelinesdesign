<script setup lang="ts">
import CommonBackground from '@/components/common/common-background/common-background.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import { onMounted, ref } from 'vue';

const isLoaded = ref<boolean>(false);

onMounted(() => {
    setTimeout(() => {
        isLoaded.value = true;
    }, 300);
});
</script>

<template>
    <navbar-layout>
        <common-background image-url="/images/background/about-bg.jpg">
            <div class="about-widget-card max-w-sm rounded-lg bg-white p-6 shadow-md">
                <h3 class="mb-2 text-center text-xl font-semibold">About Dandelines Designs</h3>

                <p class="mb-3 text-center text-sm text-gray-600 italic">Creative Design Event Planning</p>

                <hr class="mx-auto mb-3 w-16 border-t border-gray-300" />

                <p class="text-center text-sm text-gray-700">
                    At Dandelines Designs, we believe in creating beautiful events that bring your vision to life. We specialiaze in custom design,
                    and the fine details that make your moment special.
                </p>
            </div>
        </common-background>
    </navbar-layout>
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
