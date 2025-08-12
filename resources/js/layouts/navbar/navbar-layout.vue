<script setup lang="ts">
import UiNavbar from '@/components/ui/navigation/navbar/ui-navbar.vue';
import type { NavbarLayoutConfig } from './navbar-layout.config';
import defaultConfig from './navbar-layout.config';

interface Props {
    config?: NavbarLayoutConfig;
}

const props = withDefaults(defineProps<Props>(), {
    config: () => defaultConfig,
});

const toggleSidebar = () => {
    console.log('Toggle sidebar event received');
};
</script>

<template>
    <div class="flex min-h-screen flex-col bg-gray-50">
        <ui-navbar :title="props.config.title" @toggle-sidebar="toggleSidebar">
            <template #right>
                <div class="flex items-center space-x-4">
                    <button
                        v-for="(item, index) in props.config.navbarRightItems"
                        :key="index"
                        class="rounded-full p-2 text-gray-500 hover:bg-gray-100"
                        :aria-label="item.ariaLabel"
                        @click="item.onClick && item.onClick()"
                    >
                        <component :is="item.icon" class="h-5 w-5" />
                    </button>
                </div>
            </template>
        </ui-navbar>

        <main class="flex-1 p-4">
            <div class="mx-auto max-w-7xl">
                <slot />
            </div>
        </main>
    </div>
</template>
