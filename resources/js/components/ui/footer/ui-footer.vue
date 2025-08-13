<script setup lang="ts">
import { Mail, MapPin, Phone } from 'lucide-vue-next';
import { ref } from 'vue';
import type { UiFooterProps as Props, UiFooterEmits as Emits } from './ui-footer';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const currentYear = new Date().getFullYear();

const handleAdminLogin = (): void => {
    emit('admin-login-click');
};
</script>

<template>
    <footer class="bg-gray-100 pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                <div class="mb-8 md:mb-0">
                    <h2 class="mb-4 text-xl font-bold text-gray-900">Dandelines Design</h2>
                    <p class="mb-4 text-gray-600">
                        Creating beautiful events that bring your vision to life and the fine details that make your moments special.
                    </p>
                    <div class="flex space-x-4">
                        <a
                            v-for="social in socialLinks"
                            :key="social.name"
                            :href="social.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-gray-600 transition-colors hover:text-gray-900"
                            :aria-label="social.name"
                        >
                            <component :is="social.icon" class="h-5 w-5" />
                        </a>
                    </div>
                </div>

                <div v-for="group in navigationLinks" :key="group.title" class="mb-8 md:mb-0">
                    <h3 class="mb-4 font-semibold text-gray-900">{{ group.title }}</h3>
                    <ul class="space-y-2">
                        <li v-for="link in group.links" :key="link.name">
                            <a :href="link.href" class="text-gray-600 transition-colors hover:text-gray-900">
                                {{ link.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-8 md:mb-0">
                    <h3 class="mb-4 font-semibold text-gray-900">Contact Us</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <Mail class="mr-2 h-5 w-5 text-gray-600" />
                            <a :href="`mailto:${contactInfo.email}`" class="text-gray-600 transition-colors hover:text-gray-900">
                                {{ contactInfo.email }}
                            </a>
                        </li>
                        <li class="flex items-start">
                            <Phone class="mr-2 h-5 w-5 text-gray-600" />
                            <a :href="`tel:${contactInfo.phone}`" class="text-gray-600 transition-colors hover:text-gray-900">
                                {{ contactInfo.phone }}
                            </a>
                        </li>
                        <li class="flex items-start">
                            <MapPin class="mr-2 h-5 w-5 text-gray-600" />
                            <span class="text-gray-600">{{ contactInfo.address }}</span>
                        </li>
                    </ul>
                    <button
                        @click="handleAdminLogin"
                        class="mt-4 inline-flex items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:outline-none"
                    >
                        Admin Login
                    </button>
                </div>
            </div>

            <div class="my-8 border-t border-gray-200"></div>

            <div class="flex flex-col items-center justify-between space-y-4 md:flex-row md:space-y-0">
                <p class="text-sm text-gray-600">&copy; {{ currentYear }} Dandelines Design. All rights reserved.</p>
            </div>
        </div>
    </footer>
</template>
