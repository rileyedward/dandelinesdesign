<script setup lang="ts">
import NotificationDrawer from '@/components/notification/notification-drawer/notification-drawer.vue';
import UiSidebar from '@/components/ui/navigation/sidebar/ui-sidebar.vue';
import { useSidebarState } from '@/composables/useSidebarState';
import { ref, watch } from 'vue';
import defaultConfig from './sidebar-layout.config';

const activeRoute = ref('');
const showNotificationDrawer = ref(false);
const { isOpen: isSidebarOpen } = useSidebarState();

watch(activeRoute, (newRoute) => {
    if (newRoute === '#notifications') {
        showNotificationDrawer.value = true;
        // Reset the active route to prevent the sidebar from highlighting the notifications item
        setTimeout(() => {
            activeRoute.value = '';
        }, 100);
    }
});
</script>

<template>
    <div class="flex min-h-screen bg-gray-50">
        <ui-sidebar
            v-model:active-route="activeRoute"
            :items="defaultConfig.sidebarItems"
            :title="defaultConfig.title"
            :default-open="isSidebarOpen"
            :profile-menu="defaultConfig.profileMenu"
        />

        <div class="flex flex-1 flex-col transition-all duration-300 ease-in-out" :class="isSidebarOpen ? 'md:ml-[250px]' : 'md:ml-[60px]'">
            <main class="flex-1 p-4">
                <div class="mx-auto max-w-7xl">
                    <slot />
                </div>
            </main>
        </div>

        <notification-drawer :show="showNotificationDrawer" @update:show="showNotificationDrawer = $event" />
    </div>
</template>

<style scoped>
@media (max-width: 768px) {
    .min-h-screen {
        flex-direction: column;
    }
}
</style>
