<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import { Menu as MenuIcon } from 'lucide-vue-next';
import type { UiNavbarProps as Props, UiNavbarEmits as Emits } from './ui-navbar';

const props = withDefaults(defineProps<Props>(), {
  title: 'Component Library',
  items: () => [],
  showMobileMenuButton: true,
  showLogo: true,
  logoSrc: '',
  fixed: true,
  transparent: false,
  activeRoute: '',
});

const emit = defineEmits<Emits>();

const activeRouteValue = ref(props.activeRoute);

const route = useRoute();

watch(
  () => props.activeRoute,
  newValue => {
    activeRouteValue.value = newValue;
  }
);

watch(
  () => route.path,
  newPath => {
    activeRouteValue.value = newPath;
  }
);

const toggleSidebar = (): void => {
  emit('toggle-sidebar');
};

const navbarClasses = computed(() => {
  return [
    'bg-white border-b border-gray-200',
    props.fixed ? 'sticky top-0 z-30' : 'relative',
    props.transparent ? 'bg-transparent border-transparent' : '',
  ];
});
</script>

<template>
  <nav :class="navbarClasses">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <div class="flex items-center md:hidden">
            <button
              v-if="showMobileMenuButton"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500"
              @click="toggleSidebar"
            >
              <span class="sr-only">Toggle sidebar</span>
              <menu-icon class="h-6 w-6" />
            </button>
          </div>

          <div class="flex-shrink-0 flex items-center">
            <img v-if="showLogo && logoSrc" :src="logoSrc" class="h-8 w-auto" alt="Logo" />
            <span v-if="title" class="text-lg font-semibold text-gray-900 ml-2">{{ title }}</span>
          </div>

          <div class="hidden md:ml-6 md:flex md:space-x-4">
            <slot name="items"></slot>
          </div>
        </div>

        <div class="flex items-center">
          <slot name="right"></slot>
        </div>
      </div>
    </div>
  </nav>
</template>
