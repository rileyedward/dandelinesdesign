<script setup lang="ts">
import StoreSplash from '@/components/store/store-splash.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import { Head } from '@inertiajs/vue3';
import { Sparkles, Bell, Instagram, Facebook, MessageSquareIcon } from 'lucide-vue-next';
</script>

<template>
    <Head title="Store - Dandelines Design" />
    
    <navbar-layout>
        <!-- Hero Section -->
        <store-splash />
        
        <!-- Coming Soon Section -->
        <section class="py-16 bg-gradient-to-br from-amber-50 to-orange-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Coming Soon Badge -->
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-amber-100 to-orange-100 text-amber-800 text-sm font-medium mb-6">
                    <Sparkles class="w-4 h-4 mr-2" />
                    Coming Soon
                </div>
                
                <!-- Main Heading -->
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Beautiful Products Are On Their Way
                </h2>
                
                <!-- Description -->
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                    We're carefully curating a collection of stunning handcrafted designs, elegant floral arrangements, 
                    and exclusive artwork that will bring beauty to your life and events.
                </p>
                
                
                <!-- Call to Action -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 border border-amber-200/50 shadow-xl">
                    <div class="flex items-center justify-center mb-4">
                        <Bell class="w-8 h-8 text-amber-600 mr-3" />
                        <h3 class="text-2xl font-bold text-gray-900">Stay Tuned!</h3>
                    </div>
                    <p class="text-gray-600 mb-6 text-lg">
                        Our online store is launching soon with carefully selected products that reflect our commitment to beauty and quality. 
                        Be the first to know when we go live!
                    </p>
                    <p class="text-amber-600 font-medium mb-6">
                        Follow us on social media for updates on our grand opening:
                    </p>
                    
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
