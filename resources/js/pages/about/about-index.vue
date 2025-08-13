<script setup lang="ts">
import CommonBackground from '@/components/common/common-background/common-background.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import { onMounted, ref } from 'vue';
import { aboutCopy, profileImageUrl } from '@/pages/about/about-index.config';

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

        <div class="container mx-auto px-4 py-12">
            <div class="mx-auto flex max-w-4xl flex-col items-center gap-8 md:flex-row">
                <div class="w-full md:w-1/3">
                    <img
                        :src="profileImageUrl"
                        alt="Michele Grotenhuis"
                        class="h-64 w-full rounded-lg object-cover object-center shadow-md md:h-screen md:max-h-[24rem]"
                    />
                </div>
                <div class="w-full md:w-2/3">
                    <div class="space-y-4">
                        <p v-for="(copy, index) in aboutCopy" :key="index">
                            {{ copy }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
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
