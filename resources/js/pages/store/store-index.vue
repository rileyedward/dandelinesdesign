<script setup lang="ts">
import StoreSplash from '@/components/store/store-splash.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import { Head } from '@inertiajs/vue3';
import { Bell, Facebook, Instagram, MessageSquareIcon, Sparkles } from 'lucide-vue-next';
</script>

<template>
    <Head title="Store - Dandelines Design" />

    <navbar-layout>
        <!-- Hero Section -->
        <store-splash />

        <!-- Coming Soon Section -->
        <section class="bg-gradient-to-br from-amber-50 to-orange-50 py-16">
            <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
                <!-- Coming Soon Badge -->
                <div
                    class="mb-6 inline-flex items-center rounded-full bg-gradient-to-r from-amber-100 to-orange-100 px-4 py-2 text-sm font-medium text-amber-800"
                >
                    <Sparkles class="mr-2 h-4 w-4" />
                    Coming Soon
                </div>

                <!-- Main Heading -->
                <h2 class="mb-6 text-4xl font-bold text-gray-900 md:text-5xl">Beautiful Products Are On Their Way</h2>

                <!-- Description -->
                <p class="mx-auto mb-8 max-w-2xl text-xl leading-relaxed text-gray-600">
                    We're carefully curating a collection of stunning handcrafted designs, elegant floral arrangements, and exclusive artwork that
                    will bring beauty to your life and events.
                </p>

                <!-- Call to Action -->
                <div class="rounded-2xl border border-amber-200/50 bg-white/80 p-8 shadow-xl backdrop-blur-sm">
                    <div class="mb-4 flex items-center justify-center">
                        <Bell class="mr-3 h-8 w-8 text-amber-600" />
                        <h3 class="text-2xl font-bold text-gray-900">Stay Tuned!</h3>
                    </div>
                    <p class="mb-6 text-lg text-gray-600">
                        Our online store is launching soon with carefully selected products that reflect our commitment to beauty and quality. Be the
                        first to know when we go live!
                    </p>
                    <p class="mb-6 font-medium text-amber-600">Follow us on social media for updates on our grand opening:</p>

                    <!-- Social Media Links -->
                    <div class="flex justify-center space-x-4">
                        <a
                            href="https://www.instagram.com/dandelines_design"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-amber-400 to-orange-500 text-white transition-all duration-300 hover:scale-110 hover:shadow-lg"
                            aria-label="Follow us on Instagram"
                        >
                            <Instagram class="h-6 w-6" />
                        </a>
                        <a
                            href="https://www.facebook.com/michele.grotenhuis"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-amber-400 to-orange-500 text-white transition-all duration-300 hover:scale-110 hover:shadow-lg"
                            aria-label="Follow us on Facebook"
                        >
                            <Facebook class="h-6 w-6" />
                        </a>
                        <a
                            href="https://www.threads.com/@michelegrotenhuis"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-amber-400 to-orange-500 text-white transition-all duration-300 hover:scale-110 hover:shadow-lg"
                            aria-label="Follow us on Threads"
                        >
                            <MessageSquareIcon class="h-6 w-6" />
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </navbar-layout>
</template>
