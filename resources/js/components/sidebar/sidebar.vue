<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Menu, X } from 'lucide-vue-next';
import { sidebarLinks } from './sidebar.config';

const isMobileMenuOpen = ref(false);
const isMobile = ref(false);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const checkMobile = () => {
    isMobile.value = window.innerWidth < 768;
};

onMounted(() => {
    window.addEventListener('resize', checkMobile);
    checkMobile();
});

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
});
</script>

<template>
    <!-- Mobile Toggle Button -->
    <div class="fixed top-4 left-4 z-50 md:hidden">
        <button type="button" class="text-gray-700 hover:text-gray-900" @click="toggleMobileMenu">
            <Menu v-if="!isMobileMenuOpen" class="h-6 w-6" />
            <X v-else class="h-6 w-6" />
        </button>
    </div>

    <!-- Desktop Sidebar -->
    <aside
        class="fixed top-0 left-0 z-40 hidden h-screen w-64 bg-white shadow-md transition-transform md:block"
        :class="{ '-translate-x-full': isMobile && !isMobileMenuOpen, 'translate-x-0': !isMobile || isMobileMenuOpen }"
    >
        <div class="flex h-20 items-center justify-center border-b">
            <a href="/" class="flex flex-col items-center">
                <img src="/images/app-logo.png" alt="Dandelines Design Logo" class="h-10 w-auto" />
                <span class="text-xs font-semibold text-gray-900">Dandelines Design</span>
            </a>
        </div>
        <div class="py-4">
            <ul class="space-y-2 px-3">
                <li v-for="link in sidebarLinks" :key="link.name">
                    <a
                        :href="link.href"
                        class="flex items-center rounded-lg p-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    >
                        <component :is="link.icon" class="mr-3 h-5 w-5" />
                        <span>{{ link.name }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div
        v-if="isMobile && isMobileMenuOpen"
        class="fixed inset-0 z-30 bg-black bg-opacity-50 transition-opacity md:hidden"
        @click="toggleMobileMenu"
    ></div>

    <!-- Mobile Sidebar -->
    <aside
        v-if="isMobile"
        class="fixed top-0 left-0 z-40 h-screen w-64 transform bg-white shadow-md transition-transform md:hidden"
        :class="{ '-translate-x-full': !isMobileMenuOpen, 'translate-x-0': isMobileMenuOpen }"
    >
        <div class="flex h-20 items-center justify-center border-b">
            <a href="/" class="flex flex-col items-center">
                <img src="/images/app-logo.png" alt="Dandelines Design Logo" class="h-10 w-auto" />
                <span class="text-xs font-semibold text-gray-900">Dandelines Design</span>
            </a>
        </div>
        <div class="py-4">
            <ul class="space-y-2 px-3">
                <li v-for="link in sidebarLinks" :key="link.name">
                    <a
                        :href="link.href"
                        class="flex items-center rounded-lg p-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                        @click="toggleMobileMenu"
                    >
                        <component :is="link.icon" class="mr-3 h-5 w-5" />
                        <span>{{ link.name }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

</template>
