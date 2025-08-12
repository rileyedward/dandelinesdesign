<script setup lang="ts">
import { ref, computed, onBeforeUnmount, nextTick } from 'vue';
import type {
  UiDropdownMenuProps as Props,
  UiDropdownMenuEmits as Emits,
  DropdownMenuItem,
} from './ui-dropdown-menu.ts';

const props = withDefaults(defineProps<Props>(), {
  placement: 'bottom',
  disabled: false,
  closeOnSelect: true,
  maxHeight: '200px',
});

const emit = defineEmits<Emits>();

const isOpen = ref(false);
const triggerRef = ref<HTMLElement>();
const menuRef = ref<HTMLElement>();

const menuClasses = computed<string>(() => {
  const classes: string[] = [
    'absolute z-50 min-w-48 bg-white border border-gray-200 rounded-md shadow-lg transition-all duration-200',
    'overflow-y-auto',
  ];

  if (isOpen.value) {
    classes.push('opacity-100 visible scale-100');
  } else {
    classes.push('opacity-0 invisible scale-95');
  }

  return classes.join(' ');
});

const menuPosition = computed<string>(() => {
  const classes: string[] = [];

  switch (props.placement) {
    case 'top':
      classes.push('bottom-full left-0 mb-2');
      break;
    case 'bottom':
      classes.push('top-full left-0 mt-2');
      break;
    case 'left':
      classes.push('right-full top-0 mr-2');
      break;
    case 'right':
      classes.push('left-full top-0 ml-2');
      break;
  }

  return classes.join(' ');
});

const toggleMenu = (): void => {
  if (props.disabled) return;

  if (isOpen.value) {
    closeMenu();
  } else {
    openMenu();
  }
};

const openMenu = (): void => {
  if (props.disabled) return;

  isOpen.value = true;
  emit('open');

  nextTick(() => {
    document.addEventListener('click', handleOutsideClick);
    document.addEventListener('keydown', handleKeydown);
  });
};

const closeMenu = (): void => {
  isOpen.value = false;
  emit('close');

  document.removeEventListener('click', handleOutsideClick);
  document.removeEventListener('keydown', handleKeydown);
};

const handleOutsideClick = (event: Event): void => {
  if (
    triggerRef.value &&
    menuRef.value &&
    !triggerRef.value.contains(event.target as Node) &&
    !menuRef.value.contains(event.target as Node)
  ) {
    closeMenu();
  }
};

const handleKeydown = (event: KeyboardEvent): void => {
  if (event.key === 'Escape') {
    closeMenu();
  }
};

const handleItemClick = (item: DropdownMenuItem): void => {
  if (item.disabled || item.separator) return;

  if (item.action) {
    item.action();
  } else if (item.href) {
    window.location.href = item.href;
  }

  emit('select', item);

  if (props.closeOnSelect) {
    closeMenu();
  }
};

const getItemClasses = (item: DropdownMenuItem): string => {
  const classes: string[] = [
    'flex items-center gap-3 w-full px-4 py-2 text-left text-sm transition-colors duration-150',
  ];

  if (item.separator) {
    classes.push('border-t border-gray-200 mt-2 pt-2');
  }

  if (item.disabled) {
    classes.push('opacity-50 cursor-not-allowed text-gray-400');
  } else if (item.variant === 'danger') {
    classes.push('text-red-600 hover:bg-red-50 hover:text-red-700');
  } else {
    classes.push('text-gray-700 hover:bg-gray-50 hover:text-gray-900');
  }

  return classes.join(' ');
};

onBeforeUnmount(() => {
  document.removeEventListener('click', handleOutsideClick);
  document.removeEventListener('keydown', handleKeydown);
});
</script>

<template>
  <div class="relative inline-block">
    <div
      ref="triggerRef"
      :class="['cursor-pointer', { 'opacity-50 cursor-not-allowed': disabled }]"
      @click="toggleMenu"
    >
      <slot />
    </div>

    <div ref="menuRef" :class="[menuClasses, menuPosition]" :style="{ maxHeight }" role="menu">
      <div class="py-2">
        <button
          v-for="item in items"
          :key="item.id"
          :class="getItemClasses(item)"
          :disabled="item.disabled || item.separator"
          type="button"
          role="menuitem"
          @click="handleItemClick(item)"
        >
          <component :is="item.icon" v-if="item.icon" class="h-4 w-4 flex-shrink-0" />
          <span class="flex-1">{{ item.label }}</span>
        </button>
      </div>
    </div>
  </div>
</template>
