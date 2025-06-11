<script setup lang="ts">
import AppLayout from '@/layouts/app-layout.vue';
import { onMounted, ref } from 'vue';

const isLoaded = ref(false);

onMounted(() => {
    setTimeout(() => {
        isLoaded.value = true;
    }, 300);
});
</script>

<template>
    <app-layout>
        <div class="flex h-screen flex-col items-center bg-white pt-12 md:pt-24 overflow-hidden">
            <div class="text-center">
                <transition
                    enter-active-class="transition duration-2000 transform delay-600"
                    enter-from-class="opacity-0 scale-0 rotate-180"
                    enter-to-class="opacity-100 scale-100 rotate-0"
                >
                    <img
                        v-if="isLoaded"
                        src="/images/app-logo.png"
                        alt="Dandelines Design Logo"
                        class="mx-auto mb-8 h-40 w-auto animate-pulse hover:animate-bounce"
                    />
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out"
                    enter-from-class="opacity-0 -translate-x-full"
                    enter-to-class="opacity-100 translate-x-0"
                >
                    <h1 v-if="isLoaded" class="mb-4 text-5xl font-bold text-gray-900">
                        Dandelines Design
                    </h1>
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out delay-200"
                    enter-from-class="opacity-0 translate-x-full"
                    enter-to-class="opacity-100 translate-x-0"
                >
                    <h2 v-if="isLoaded" class="mb-4 text-3xl font-semibold text-gray-800">
                        Michele Grotenhuis
                    </h2>
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out delay-400"
                    enter-from-class="opacity-0 scale-50"
                    enter-to-class="opacity-100 scale-100"
                >
                    <p v-if="isLoaded" class="mb-8 text-xl text-gray-700">
                        Event Planning & Design Services
                    </p>
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out delay-800"
                    enter-from-class="opacity-0 translate-y-20"
                    enter-to-class="opacity-100 translate-y-0"
                >
                    <a
                        v-if="isLoaded"
                        href="/contact"
                        class="inline-block rounded-lg bg-gray-600 px-8 py-3 font-bold text-white transition duration-300 hover:bg-pink-500 hover:scale-110 hover:rotate-2 transform"
                    >
                        Get in Touch
                    </a>
                </transition>
            </div>
        </div>
    </app-layout>
</template>
