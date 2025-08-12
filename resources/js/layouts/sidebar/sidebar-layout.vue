<script setup lang="ts">
import { ref } from 'vue';
import UiSidebar from '@/components/navigation/sidebar/ui-sidebar.vue';
import defaultConfig from './sidebar-layout.config';
import type { SidebarLayoutConfig } from './sidebar-layout.config';

interface Props {
  config?: SidebarLayoutConfig;
}

const props = withDefaults(defineProps<Props>(), {
  config: () => defaultConfig,
});

const activeRoute = ref('');
const isSidebarOpen = ref(true);
</script>

<template>
  <div class="min-h-screen bg-gray-50 flex">
    <ui-sidebar
      v-model:active-route="activeRoute"
      :items="props.config.sidebarItems"
      :title="props.config.title"
      :default-open="isSidebarOpen"
      :profile-menu="props.config.profileMenu"
    />

    <div
      class="flex flex-col flex-1 transition-all duration-300 ease-in-out"
      :class="isSidebarOpen ? 'md:ml-[250px]' : 'md:ml-[60px]'"
    >
      <main class="flex-1 p-4">
        <div class="max-w-7xl mx-auto">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<style scoped>
@media (max-width: 768px) {
  .min-h-screen {
    flex-direction: column;
  }
}
</style>
