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
        <div
            class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden bg-gradient-to-br from-slate-50 via-stone-50 to-rose-50"
        >
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-20 -left-20 h-96 w-96 rounded-full bg-gradient-to-br from-rose-200/30 to-pink-300/20 blur-3xl"></div>
                <div class="absolute -right-20 -bottom-20 h-96 w-96 rounded-full bg-gradient-to-br from-amber-200/30 to-orange-300/20 blur-3xl"></div>
                <div
                    class="absolute top-1/3 left-1/2 h-64 w-64 -translate-x-1/2 rounded-full bg-gradient-to-br from-purple-200/20 to-pink-200/20 blur-2xl"
                ></div>
            </div>

            <div class="relative z-10 px-6 text-center">
                <transition
                    enter-active-class="transition duration-2000 ease-out delay-600"
                    enter-from-class="opacity-0 transform scale-95"
                    enter-to-class="opacity-100 transform scale-100"
                >
                    <div v-if="isLoaded">
                        <div class="relative inline-block">
                            <div class="absolute -inset-4 rounded-full bg-white/60 blur-2xl"></div>
                            <img src="/images/app-logo.png" alt="Dandelines Design Logo" class="relative mx-auto h-40 w-auto drop-shadow-2xl" />
                        </div>
                    </div>
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out"
                    enter-from-class="opacity-0 transform translate-y-8"
                    enter-to-class="opacity-100 transform translate-y-0"
                >
                    <h1 v-if="isLoaded" class="mb-6 text-6xl font-bold tracking-tight text-gray-900 lg:text-7xl">
                        Dandelines Design
                    </h1>
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out delay-200"
                    enter-from-class="opacity-0 transform translate-y-4"
                    enter-to-class="opacity-100 transform translate-y-0"
                >
                    <h2 v-if="isLoaded" class="mb-6 text-4xl font-semibold text-gray-800 lg:text-5xl">Michele Grotenhuis</h2>
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out delay-400"
                    enter-from-class="opacity-0 transform translate-y-4"
                    enter-to-class="opacity-100 transform translate-y-0"
                >
                    <div v-if="isLoaded" class="mb-8">
                        <div class="mx-auto mb-6 h-1 w-24 rounded-full bg-gradient-to-r from-rose-400 to-pink-500"></div>
                        <p class="text-2xl font-medium text-gray-700 lg:text-3xl">
                            <span class="mx-2 inline-block">Artist</span>
                            <span class="text-rose-400">•</span>
                            <span class="mx-2 inline-block">Event Planning</span>
                            <span class="text-pink-400">•</span>
                            <span class="mx-2 inline-block">Design</span>
                        </p>
                    </div>
                </transition>

                <transition
                    enter-active-class="transition duration-2000 ease-out delay-800"
                    enter-from-class="opacity-0 transform translate-y-8"
                    enter-to-class="opacity-100 transform translate-y-0"
                >
                    <div v-if="isLoaded" class="space-y-4">
                        <a
                            href="/contact"
                            class="inline-flex items-center rounded-full bg-gradient-to-r from-rose-500 to-pink-600 px-8 py-4 text-lg font-bold text-white transition-all duration-300 hover:scale-105 hover:from-rose-600 hover:to-pink-700 hover:shadow-2xl"
                        >
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                />
                            </svg>
                            Get in Touch
                        </a>

                        <div class="mt-6 flex justify-center space-x-6">
                            <a
                                href="/about"
                                class="group inline-flex items-center text-lg font-medium text-gray-700 transition-colors hover:text-rose-600"
                            >
                                Learn More
                                <svg
                                    class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>

                            <a
                                href="/services"
                                class="group inline-flex items-center text-lg font-medium text-gray-700 transition-colors hover:text-amber-600"
                            >
                                View Services
                                <svg
                                    class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </transition>
            </div>

            <transition
                enter-active-class="transition duration-2000 ease-out delay-1200"
                enter-from-class="opacity-0 transform translate-y-4"
                enter-to-class="opacity-100 transform translate-y-0"
            >
                <div v-if="isLoaded" class="absolute bottom-8 left-1/2 -translate-x-1/2 transform">
                    <div class="flex flex-col items-center text-gray-500">
                        <span class="mb-2 text-sm font-medium">Discover More</span>
                        <div class="flex h-8 w-5 justify-center rounded-full border-2 border-gray-400">
                            <div class="mt-2 h-2 w-1 animate-bounce rounded-full bg-gray-400"></div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <div class="bg-white py-24">
            <div class="container mx-auto px-6">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-16 text-center">
                        <h2 class="mb-4 text-4xl font-bold tracking-tight text-gray-900">Why Choose Dandelines Design</h2>
                        <div class="mx-auto h-1 w-24 bg-gradient-to-r from-rose-400 to-pink-500"></div>
                        <p class="mx-auto mt-4 max-w-2xl text-lg text-gray-600">
                            Creating beautiful, memorable experiences through thoughtful design and meticulous attention to detail
                        </p>
                    </div>

                    <div class="grid gap-8 md:grid-cols-3">
                        <div
                            class="group rounded-2xl bg-gradient-to-br from-rose-50 to-pink-50 p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl"
                        >
                            <div
                                class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-rose-500 to-pink-600 text-white"
                            >
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                    />
                                </svg>
                            </div>
                            <h3 class="mb-4 text-xl font-bold text-gray-900">Passion-Driven Creativity</h3>
                            <p class="text-gray-700">
                                Every project is infused with genuine love for art, design, and creating meaningful experiences that reflect your
                                unique vision.
                            </p>
                        </div>

                        <div
                            class="group rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50 p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl"
                        >
                            <div
                                class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-amber-500 to-orange-600 text-white"
                            >
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            <h3 class="mb-4 text-xl font-bold text-gray-900">Meticulous Attention</h3>
                            <p class="text-gray-700">
                                From initial concept to final execution, every detail is carefully considered to ensure your event or design exceeds
                                expectations.
                            </p>
                        </div>

                        <div
                            class="group rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl"
                        >
                            <div
                                class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-purple-500 to-pink-600 text-white"
                            >
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="mb-4 text-xl font-bold text-gray-900">Innovative Solutions</h3>
                            <p class="text-gray-700">
                                Combining traditional artistry with fresh perspectives to deliver unique, creative solutions for every project and
                                client.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-rose-500 to-pink-600 py-20">
            <div class="container mx-auto px-6 text-center">
                <div class="mx-auto max-w-3xl">
                    <h2 class="mb-6 text-4xl font-bold text-white">Ready to Bring Your Vision to Life?</h2>
                    <p class="mb-8 text-xl text-rose-100">
                        Let's collaborate to create something truly special. Whether it's an unforgettable event, stunning floral arrangements, or
                        custom artwork, your creative journey starts here.
                    </p>

                    <div class="flex flex-col gap-4 sm:flex-row sm:justify-center">
                        <a
                            href="/contact"
                            class="inline-flex items-center rounded-full bg-white px-8 py-4 text-lg font-bold text-rose-600 transition-all duration-300 hover:scale-105 hover:bg-rose-50 hover:shadow-xl"
                        >
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>
                            Start Your Project
                        </a>

                        <a
                            href="/services"
                            class="inline-flex items-center rounded-full border-2 border-white px-8 py-4 text-lg font-bold text-white transition-all duration-300 hover:scale-105 hover:bg-white hover:text-rose-600"
                        >
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                />
                            </svg>
                            Explore Services
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </navbar-layout>
</template>
