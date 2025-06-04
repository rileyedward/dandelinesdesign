<script setup lang="ts">
import { Menu, X } from 'lucide-vue-next';
import { onMounted, onUnmounted, ref } from 'vue';
import { leftNavLinks, rightNavLinks } from './navbar.config';

const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 10;
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    handleScroll();
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <nav class="fixed top-0 right-0 left-0 z-50 w-full bg-white transition-shadow duration-300" :class="{ 'shadow-md': isScrolled }">
        <div class="container mx-auto px-4">
            <!-- Desktop Layout -->
            <div class="hidden h-20 md:flex md:items-center md:justify-between">
                <div class="md:flex md:items-center md:space-x-10 md:pl-4">
                    <a v-for="link in leftNavLinks" :key="link.name" :href="link.href" class="text-gray-700 hover:text-gray-900">
                        {{ link.name }}
                    </a>
                </div>

                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transform">
                    <a href="#" class="text-xl font-bold text-gray-900">Dandelines Design</a>
                </div>

                <div class="md:flex md:items-center md:space-x-10 md:pr-4">
                    <a v-for="link in rightNavLinks" :key="link.name" :href="link.href" class="text-gray-700 hover:text-gray-900">
                        {{ link.name }}
                    </a>
                </div>
            </div>

            <!-- Mobile Layout -->
            <div class="flex flex-col py-4 md:hidden">
                <div class="mb-4 text-center">
                    <a href="#" class="text-xl font-bold text-gray-900">Dandelines Design</a>
                </div>

                <div class="absolute top-4 right-4">
                    <button type="button" class="text-gray-700 hover:text-gray-900" @click="toggleMobileMenu">
                        <Menu v-if="!isMobileMenuOpen" class="h-6 w-6" />
                        <X v-else class="h-6 w-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div v-if="isMobileMenuOpen" class="md:hidden">
            <div class="space-y-1 px-4 pt-2 pb-3">
                <a
                    v-for="link in [...leftNavLinks, ...rightNavLinks]"
                    :key="link.name"
                    :href="link.href"
                    class="block py-2 text-gray-700 hover:text-gray-900"
                    @click="isMobileMenuOpen = false"
                >
                    {{ link.name }}
                </a>
            </div>
        </div>
    </nav>

    <div class="h-20"></div>
</template>
