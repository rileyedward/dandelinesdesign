<script setup lang="ts">
import AppLayout from '@/layouts/app-layout.vue';
</script>

<template>
    <app-layout>
        <div class="flex h-screen flex-col items-center bg-white pt-12 md:pt-24">
            <div class="text-center">
                <img src="/images/app-logo.png" alt="Dandelines Design Logo" class="mx-auto mb-8 h-40 w-auto" />

                <h1 class="mb-4 text-5xl font-bold text-gray-900">Dandelines Design</h1>
                <h2 class="mb-4 text-3xl font-semibold text-gray-800">Michele Grotenhuis</h2>
                <p class="mb-8 text-xl text-gray-700">Event Planning & Design Services</p>

                <a
                    href="/contact"
                    class="inline-block rounded-lg bg-gray-600 px-8 py-3 font-bold text-white transition duration-300 hover:bg-gray-700"
                >
                    Get in Touch
                </a>
            </div>
        </div>
    </app-layout>
</template>
