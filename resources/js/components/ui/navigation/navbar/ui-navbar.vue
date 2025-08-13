<script setup lang="ts">
import { Menu, X } from 'lucide-vue-next';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import type { UiNavbarProps as Props, UiNavbarEmits as Emits } from './ui-navbar';

withDefaults(defineProps<Props>(), {
    leftNavLinks: () => [],
    rightNavLinks: () => [],
});

const emit = defineEmits<Emits>();

const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const isIndexPage = computed<boolean>(() => window.location.pathname === '/');
const currentPath = computed<string>(() => window.location.pathname);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 10;
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
    emit('mobile-menu-toggle');
};

const isActive = (href: string): boolean => {
    if (href === '/') {
        return currentPath.value === '/';
    }
    return currentPath.value.startsWith(href);
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
    <nav
        class="fixed top-0 right-0 left-0 z-50 w-full transition-all duration-300 border-b border-transparent"
        :class="{
            'shadow-lg border-gray-100 backdrop-blur-sm bg-white/90': isScrolled,
            'bg-gradient-to-r from-white to-gray-50': !isScrolled
        }"
    >
        <div class="container mx-auto px-4">
            <div class="hidden h-20 gap-96 md:flex md:items-center md:justify-center">
                <div class="md:flex md:items-center md:space-x-10 md:pl-4">
                    <a
                        v-for="link in leftNavLinks"
                        :key="link.name"
                        :href="link.href"
                        class="relative py-2 text-gray-700 transition-all duration-300"
                        :class="{ 'font-semibold text-black': isActive(link.href) }"
                    >
                        {{ link.name }}
                        <span
                            class="absolute bottom-0 left-0 h-0.5 bg-black transition-all duration-300"
                            :class="isActive(link.href) ? 'w-full' : 'w-0 group-hover:w-full'"
                        ></span>
                    </a>
                </div>

                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transform">
                    <a href="/" class="flex flex-col items-center group transition-all duration-300 hover:scale-105">
                        <img
                            v-if="!isIndexPage"
                            src="/images/app-logo.png"
                            alt="Dandelines Design Logo"
                            class="h-10 w-auto drop-shadow-sm transition-all duration-300 group-hover:drop-shadow-md"
                        />
                        <span class="text-xs font-semibold text-gray-900 transition-all duration-300 group-hover:text-black">
                            Dandelines Design
                        </span>
                    </a>
                </div>

                <div class="md:flex md:items-center md:space-x-10 md:pr-4">
                    <a
                        v-for="link in rightNavLinks"
                        :key="link.name"
                        :href="link.href"
                        class="relative py-2 text-gray-700 transition-all duration-300 hover:text-black"
                        :class="{ 'font-semibold text-black': isActive(link.href) }"
                    >
                        {{ link.name }}
                        <span
                            class="absolute bottom-0 left-0 h-0.5 bg-black transition-all duration-300"
                            :class="isActive(link.href) ? 'w-full' : 'w-0 group-hover:w-full'"
                        ></span>
                    </a>
                </div>
            </div>

            <div class="flex flex-col py-4 md:hidden">
                <div class="absolute top-8 left-4">
                    <button
                        type="button"
                        class="rounded-full p-2 text-gray-700 transition-all duration-300 hover:bg-emerald-50 hover:text-emerald-600"
                        @click="toggleMobileMenu"
                    >
                        <Menu v-if="!isMobileMenuOpen" class="h-6 w-6" />
                        <X v-else class="h-6 w-6" />
                    </button>
                </div>

                <div class="mb-4 text-center">
                    <a href="/" class="inline-flex flex-col items-center group transition-all duration-300 hover:scale-105">
                        <img
                            src="/images/app-logo.png"
                            alt="Dandelines Design Logo"
                            class="h-10 w-auto drop-shadow-sm transition-all duration-300 group-hover:drop-shadow-md"
                        />
                        <span class="text-sm font-bold text-gray-900 transition-all duration-300 group-hover:text-emerald-600">
                            Dandelines Design
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div
            v-if="isMobileMenuOpen"
            class="md:hidden bg-gradient-to-b from-white to-gray-50 border-t border-gray-100 overflow-hidden transition-all duration-500"
            :class="{ 'max-h-[500px] opacity-100': isMobileMenuOpen, 'max-h-0 opacity-0': !isMobileMenuOpen }"
        >
            <div class="space-y-1 px-6 pt-4 pb-6">
                <a
                    v-for="link in [...leftNavLinks, ...rightNavLinks]"
                    :key="link.name"
                    :href="link.href"
                    class="block py-3 px-4 rounded-lg transition-all duration-300 hover:bg-emerald-50"
                    :class="isActive(link.href) ? 'bg-emerald-50 text-emerald-600 font-medium' : 'text-gray-700 hover:text-emerald-600'"
                    @click="isMobileMenuOpen = false"
                >
                    {{ link.name }}
                </a>
            </div>
        </div>
    </nav>

    <div class="h-20"></div>
</template>
