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

const handleScroll = () => {
    isScrolled.value = window.scrollY > 10;
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
    emit('mobile-menu-toggle');
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
            <div class="hidden h-20 gap-96 md:flex md:items-center md:justify-center">
                <div class="md:flex md:items-center md:space-x-10 md:pl-4">
                    <a v-for="link in leftNavLinks" :key="link.name" :href="link.href" class="text-gray-700 hover:text-gray-900">
                        {{ link.name }}
                    </a>
                </div>

                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transform">
                    <a href="/" class="flex flex-col items-center">
                        <img v-if="!isIndexPage" src="/images/app-logo.png" alt="Dandelines Design Logo" class="h-10 w-auto" />
                        <span class="text-xs font-semibold text-gray-900">Dandelines Design</span>
                    </a>
                </div>

                <div class="md:flex md:items-center md:space-x-10 md:pr-4">
                    <a v-for="link in rightNavLinks" :key="link.name" :href="link.href" class="text-gray-700 hover:text-gray-900">
                        {{ link.name }}
                    </a>
                </div>
            </div>

            <div class="flex flex-col py-4 md:hidden">
                <div class="absolute top-8 left-4">
                    <button type="button" class="text-gray-700 hover:text-gray-900" @click="toggleMobileMenu">
                        <Menu v-if="!isMobileMenuOpen" class="h-6 w-6" />
                        <X v-else class="h-6 w-6" />
                    </button>
                </div>

                <div class="mb-4 text-center">
                    <a href="/" class="inline-flex flex-col items-center">
                        <img src="/images/app-logo.png" alt="Dandelines Design Logo" class="h-10 w-auto" />
                        <span class="text-sm font-bold text-gray-900">Dandelines Design</span>
                    </a>
                </div>
            </div>
        </div>

        <div v-if="isMobileMenuOpen" class="md:hidden">
            <div class="h-[700px] space-y-1 px-4 pt-2 pb-3">
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
