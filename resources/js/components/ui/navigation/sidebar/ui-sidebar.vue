<script setup lang="ts">
import { ref, computed, watch, onMounted, reactive } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { ChevronDown, ChevronUp, ChevronRight, Menu as MenuIcon, User } from 'lucide-vue-next';
import type { UiSidebarProps as Props, UiSidebarEmits as Emits, SidebarItem } from './ui-sidebar';
import UiDropdownMenu from '@/components/ui/data/dropdown-menu/ui-dropdown-menu.vue';
import type { DropdownMenuItem } from '@/components/ui/data/dropdown-menu/ui-dropdown-menu';

const props = withDefaults(defineProps<Props>(), {
  title: 'Navigation',
  collapsible: true,
  defaultOpen: true,
  activeRoute: '',
  width: '250px',
});

const emit = defineEmits<Emits>();

const isOpen = ref(props.defaultOpen);
const activeRouteValue = ref(props.activeRoute);
const isMobileMenuOpen = ref(false);
const expandedItems = reactive<Record<string, boolean>>({});

const router = useRouter();
const route = useRoute();

const routes = computed(() => {
  return router
    .getRoutes()
    .filter(route => route.name && route.path !== '/' && !route.path.includes(':'))
    .map(route => ({
      label: route.name.toString().charAt(0).toUpperCase() + route.name.toString().slice(1),
      route: route.path,
    }));
});

const navItems = computed(() => {
  return props.items.length > 0 ? props.items : routes.value;
});

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

onMounted(() => {
  activeRouteValue.value = route.path;
});

const toggleSidebar = (): void => {
  if (props.collapsible) {
    isOpen.value = !isOpen.value;
  }
};

const toggleMobileMenu = (): void => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const toggleItemExpansion = (itemLabel: string): void => {
  expandedItems[itemLabel] = !expandedItems[itemLabel];
};

const handleNavigate = (item: SidebarItem): void => {
  if (!item.disabled) {
    activeRouteValue.value = item.route || '';
    emit('navigate', item);
    emit('update:activeRoute', item.route || '');

    if (item.route) {
      router.push(item.route);
    }

    isMobileMenuOpen.value = false;
  }
};

const handleProfileAction = (item: DropdownMenuItem): void => {
  emit('profile-action', item);
};

const sidebarClasses = computed(() => {
  return [
    'bg-white border-r border-gray-200 h-screen',
    'transition-all duration-300 ease-in-out',
    'overflow-y-auto',
    'w-full',
    'flex flex-col',
  ];
});
</script>

<template>
  <div>
    <div class="md:hidden p-4 flex items-center justify-between bg-white border-b border-gray-200">
      <h1 class="text-xl font-bold text-gray-900">{{ title }}</h1>
      <button
        class="p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100"
        @click="toggleMobileMenu"
      >
        <menu-icon class="w-6 h-6" />
      </button>
    </div>

    <div v-if="isMobileMenuOpen" class="md:hidden fixed inset-0 z-40 flex">
      <div class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="isMobileMenuOpen = false"></div>

      <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
        <div class="px-4 pt-5 pb-4 flex items-center justify-between">
          <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
          <button
            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500"
            @click="isMobileMenuOpen = false"
          >
            <span class="sr-only">Close sidebar</span>
            <svg
              class="h-6 w-6 text-gray-500"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>

        <div class="mt-5 flex-1 flex flex-col h-0">
          <nav class="flex-1 px-2 overflow-y-auto">
            <div class="space-y-1">
              <div v-for="item in navItems" :key="item.route || item.label">
                <div
                  :class="[
                    'group flex items-center justify-between px-2 py-2 text-base font-medium rounded-md',
                    activeRouteValue === item.route
                      ? 'bg-purple-100 text-purple-700'
                      : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                    item.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
                  ]"
                  @click.prevent="
                    item.children && item.children.length > 0
                      ? toggleItemExpansion(item.label)
                      : !item.disabled && handleNavigate(item)
                  "
                >
                  <div class="flex items-center">
                    <component
                      :is="item.icon"
                      v-if="item.icon"
                      class="mr-3 flex-shrink-0 h-6 w-6"
                    />
                    {{ item.label }}
                  </div>
                  <component
                    :is="expandedItems[item.label] ? ChevronUp : ChevronDown"
                    v-if="item.children && item.children.length > 0"
                    class="flex-shrink-0 h-5 w-5"
                  />
                </div>

                <div
                  v-if="item.children && item.children.length > 0"
                  :class="['mt-1 space-y-1 pl-4', expandedItems[item.label] ? 'block' : 'hidden']"
                >
                  <a
                    v-for="child in item.children"
                    :key="child.route || child.label"
                    :href="child.route || '#'"
                    :class="[
                      'group flex items-center px-2 py-2 text-sm font-medium rounded-md',
                      activeRouteValue === child.route
                        ? 'bg-purple-100 text-purple-700'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                      child.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
                    ]"
                    @click.prevent="!child.disabled && handleNavigate(child)"
                  >
                    <component
                      :is="child.icon"
                      v-if="child.icon"
                      class="mr-3 flex-shrink-0 h-5 w-5"
                    />
                    {{ child.label }}
                  </a>
                </div>
              </div>
            </div>
          </nav>

          <div v-if="profileMenu" class="border-t border-gray-200 px-2 py-3">
            <ui-dropdown-menu
              :items="profileMenu.menuItems"
              placement="top"
              @select="handleProfileAction"
            >
              <div
                class="flex items-center px-2 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-md cursor-pointer"
              >
                <user class="mr-3 flex-shrink-0 h-6 w-6" />
                <span class="flex-1">{{ profileMenu.userName }}</span>
                <chevron-up class="flex-shrink-0 h-5 w-5" />
              </div>
            </ui-dropdown-menu>
          </div>
        </div>
      </div>
    </div>

    <div
      class="hidden md:flex md:flex-col md:h-screen md:fixed md:top-0 md:left-0 md:z-20 transition-all duration-300 ease-in-out"
      :class="isOpen ? 'w-[250px]' : 'w-[60px]'"
    >
      <div :class="sidebarClasses">
        <div
          class="flex items-center justify-between h-16 px-4 border-b border-gray-200"
          :class="{ 'justify-center': !isOpen }"
        >
          <h2 v-if="isOpen" class="text-lg font-medium text-gray-900">{{ title }}</h2>
          <button
            class="p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100"
            @click="toggleSidebar"
          >
            <component :is="isOpen ? ChevronUp : ChevronDown" class="w-5 h-5" />
          </button>
        </div>

        <div v-if="isOpen" class="flex-1 flex flex-col overflow-y-auto">
          <nav class="flex-1 px-4 py-4 overflow-y-auto">
            <div class="space-y-1">
              <div v-for="item in navItems" :key="item.route || item.label">
                <div
                  :class="[
                    'group flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md',
                    activeRouteValue === item.route
                      ? 'bg-purple-100 text-purple-700'
                      : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                    item.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
                  ]"
                  @click.prevent="
                    item.children && item.children.length > 0
                      ? toggleItemExpansion(item.label)
                      : !item.disabled && handleNavigate(item)
                  "
                >
                  <div class="flex items-center">
                    <component
                      :is="item.icon"
                      v-if="item.icon"
                      class="mr-3 flex-shrink-0 h-5 w-5"
                    />
                    {{ item.label }}
                  </div>
                  <component
                    :is="expandedItems[item.label] ? ChevronUp : ChevronDown"
                    v-if="item.children && item.children.length > 0"
                    class="flex-shrink-0 h-4 w-4"
                  />
                </div>

                <div
                  v-if="item.children && item.children.length > 0"
                  :class="['mt-1 space-y-1 pl-4', expandedItems[item.label] ? 'block' : 'hidden']"
                >
                  <a
                    v-for="child in item.children"
                    :key="child.route || child.label"
                    :href="child.route || '#'"
                    :class="[
                      'group flex items-center px-2 py-2 text-sm font-medium rounded-md',
                      activeRouteValue === child.route
                        ? 'bg-purple-100 text-purple-700'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                      child.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
                    ]"
                    @click.prevent="!child.disabled && handleNavigate(child)"
                  >
                    <component
                      :is="child.icon"
                      v-if="child.icon"
                      class="mr-3 flex-shrink-0 h-4 w-4"
                    />
                    <span class="flex items-center">
                      <component
                        :is="ChevronRight"
                        v-if="child.children && child.children.length > 0"
                        class="mr-1 h-3 w-3"
                      />
                      {{ child.label }}
                    </span>
                  </a>
                </div>
              </div>
            </div>
          </nav>

          <div v-if="profileMenu" class="border-t border-gray-200 px-4 py-3 mt-auto">
            <ui-dropdown-menu
              :items="profileMenu.menuItems"
              placement="top"
              @select="handleProfileAction"
            >
              <div
                class="flex items-center px-2 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-md cursor-pointer"
              >
                <user class="mr-3 flex-shrink-0 h-5 w-5" />
                <span class="flex-1">{{ profileMenu.userName }}</span>
                <chevron-up class="flex-shrink-0 h-4 w-4" />
              </div>
            </ui-dropdown-menu>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
