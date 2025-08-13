<script setup lang="ts">
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
        <div class="flex h-screen flex-col items-center overflow-hidden bg-white pt-12 md:pt-24">
            <div class="text-center">
                <transition
                    enter-active-class="transition duration-2000 ease-out delay-600"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                >
                    <img v-if="isLoaded" src="/images/app-logo.png" alt="Dandelines Design Logo" class="mx-auto mb-8 h-40 w-auto" />
                </transition>

                <transition enter-active-class="transition duration-2000 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100">
                    <h1 v-if="isLoaded" class="mb-4 text-5xl font-bold text-gray-900">Dandelines Design</h1>
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out delay-200"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                >
                    <h2 v-if="isLoaded" class="mb-4 text-3xl font-semibold text-gray-800">Michele Grotenhuis</h2>
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out delay-400"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                >
                    <!-- TODO: Savate -->
                    <p v-if="isLoaded" class="mb-8 text-xl text-gray-700">Artist • Event Planning • Design</p>
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out delay-800"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                >
                    <!-- TODO: Euphoria Font -->
                    <a
                        v-if="isLoaded"
                        href="/contact"
                        class="inline-block rounded-lg bg-gray-600 px-8 py-3 font-bold text-white transition duration-300 hover:bg-pink-500"
                    >
                        Get in Touch
                    </a>
                </transition>
            </div>
        </div>
    </navbar-layout>
</template>
