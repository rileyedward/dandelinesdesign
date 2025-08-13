<script setup lang="ts">
import { Mail, MapPin, Phone } from 'lucide-vue-next';
import { ref } from 'vue';
import type { UiFooterProps as Props, UiFooterEmits as Emits } from './ui-footer';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="bg-gradient-to-b from-white to-gray-50 pt-16 pb-8 border-t border-gray-100 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                <div class="mb-8 md:mb-0">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 relative inline-block">
                        Dandelines Design
                        <div class="absolute -bottom-1 left-0 h-1 w-16 rounded-full bg-gradient-to-r from-gray-600 to-black"></div>
                    </h2>
                    <p class="mb-6 text-gray-600 leading-relaxed">
                        Creating beautiful events that bring your vision to life and the fine details that make your moments special.
                    </p>
                    <div class="flex space-x-4">
                        <a
                            v-for="social in socialLinks"
                            :key="social.name"
                            :href="social.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-gray-100 to-gray-200 text-gray-800 transition-all duration-300 hover:scale-110 hover:shadow-md hover:from-gray-200 hover:to-gray-300"
                            :aria-label="social.name"
                        >
                            <component :is="social.icon" class="h-5 w-5" />
                        </a>
                    </div>
                </div>

                <div v-for="group in navigationLinks" :key="group.title" class="mb-8 md:mb-0">
                    <h3 class="mb-4 font-semibold text-gray-900 relative inline-block">
                        {{ group.title }}
                        <div class="absolute -bottom-1 left-0 h-0.5 w-8 rounded-full bg-gradient-to-r from-gray-600 to-black"></div>
                    </h3>
                    <ul class="space-y-3">
                        <li v-for="link in group.links" :key="link.name">
                            <a
                                :href="link.href"
                                class="text-gray-600 transition-all duration-300 hover:text-black relative group"
                            >
                                <span class="relative">
                                    {{ link.name }}
                                    <span class="absolute bottom-0 left-0 h-0.5 w-0 bg-black transition-all duration-300 group-hover:w-full"></span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-8 md:mb-0">
                    <h3 class="mb-4 font-semibold text-gray-900 relative inline-block">
                        Contact Us
                        <div class="absolute -bottom-1 left-0 h-0.5 w-8 rounded-full bg-gradient-to-r from-gray-600 to-black"></div>
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start group">
                            <div class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-gray-100 to-gray-200 text-gray-800 transition-all duration-300 group-hover:scale-110 group-hover:shadow-sm">
                                <Mail class="h-4 w-4" />
                            </div>
                            <a :href="`mailto:${contactInfo.email}`" class="text-gray-600 transition-all duration-300 hover:text-black pt-1">
                                {{ contactInfo.email }}
                            </a>
                        </li>
                        <li class="flex items-start group">
                            <div class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-gray-100 to-gray-200 text-gray-800 transition-all duration-300 group-hover:scale-110 group-hover:shadow-sm">
                                <Phone class="h-4 w-4" />
                            </div>
                            <a :href="`tel:${contactInfo.phone}`" class="text-gray-600 transition-all duration-300 hover:text-black pt-1">
                                {{ contactInfo.phone }}
                            </a>
                        </li>
                        <li class="flex items-start group">
                            <div class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-gray-100 to-gray-200 text-gray-800 transition-all duration-300 group-hover:scale-110 group-hover:shadow-sm">
                                <MapPin class="h-4 w-4" />
                            </div>
                            <span class="text-gray-600 pt-1">{{ contactInfo.address }}</span>
                        </li>
                    </ul>
                    <a
                        href="/auth/login"
                        class="mt-6 inline-flex items-center justify-center rounded-full bg-gradient-to-r from-gray-700 to-black px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:scale-105 hover:shadow-lg hover:from-gray-800 hover:to-black"
                    >
                        Admin Login
                    </a>
                </div>
            </div>

            <div class="my-10 border-t border-gray-200"></div>

            <div class="flex flex-col items-center justify-between space-y-4 md:flex-row md:space-y-0">
                <p class="text-sm text-gray-500">&copy; {{ currentYear }} Dandelines Design. All rights reserved.</p>
                <p class="text-xs text-gray-400">Crafted with ❤️ for beautiful events</p>
            </div>
        </div>
    </footer>
</template>
