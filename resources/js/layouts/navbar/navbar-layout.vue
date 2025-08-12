<script setup lang="ts">
import UiNavbar from '@/components/navigation/navbar/ui-navbar.vue';
import defaultConfig from './navbar-layout.config';
import type { NavbarLayoutConfig } from './navbar-layout.config';

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
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <ui-navbar :title="props.config.title" @toggle-sidebar="toggleSidebar">
      <template #right>
        <div class="flex items-center space-x-4">
          <button
            v-for="(item, index) in props.config.navbarRightItems"
            :key="index"
            class="p-2 rounded-full text-gray-500 hover:bg-gray-100"
            :aria-label="item.ariaLabel"
            @click="item.onClick && item.onClick()"
          >
            <component :is="item.icon" class="h-5 w-5" />
          </button>
        </div>
      </template>
    </ui-navbar>

    <main class="flex-1 p-4">
      <div class="max-w-7xl mx-auto">
        <slot />
      </div>
    </main>
  </div>
</template>
