<script setup lang="ts">
import { Home } from 'lucide-vue-next';
import type {
  UiBreadcrumbProps as Props,
  UiBreadcrumbEmits as Emits,
  BreadcrumbItem,
} from './ui-breadcrumb';

withDefaults(defineProps<Props>(), {
  separator: '/',
  showHomeIcon: true,
  homeIcon: () => Home,
});

const emit = defineEmits<Emits>();

const handleNavigate = (item: BreadcrumbItem): void => {
  emit('navigate', item);
};
</script>

<template>
  <nav aria-label="Breadcrumb" class="flex">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
      <li v-if="showHomeIcon" class="inline-flex items-center">
        <a
          href="/"
          class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-purple-600"
        >
          <component :is="homeIcon" class="w-4 h-4 mr-2" />
        </a>
      </li>

      <li v-for="(item, index) in items" :key="index" class="inline-flex items-center">
        <span class="mx-1 text-gray-400">{{ separator }}</span>
        <a
          :href="item.href || '#'"
          class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-purple-600"
          @click.prevent="handleNavigate(item)"
        >
          <component :is="item.icon" v-if="item.icon" class="w-4 h-4 mr-1" />
          {{ item.label }}
        </a>
      </li>
    </ol>
  </nav>
</template>
