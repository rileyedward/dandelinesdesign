<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import type { UiTooltipProps as Props, UiTooltipEmits as Emits } from './ui-tooltip';

const props = withDefaults(defineProps<Props>(), {
  placement: 'top',
  disabled: false,
  delay: 0,
  theme: 'dark',
  arrow: true,
});

const emit = defineEmits<Emits>();

const isVisible = ref(false);
const triggerRef = ref<HTMLElement>();
const tooltipRef = ref<HTMLElement>();
let showTimeout: NodeJS.Timeout | null = null;
let hideTimeout: NodeJS.Timeout | null = null;

const tooltipClasses = computed<string>(() => {
  const classes: string[] = [
    'absolute z-50 px-2 py-1 text-sm font-medium rounded-md shadow-lg transition-opacity duration-200 pointer-events-none',
    'max-w-xs break-words',
  ];

  if (props.theme === 'dark') {
    classes.push('bg-gray-900 text-white');
  } else {
    classes.push('bg-white text-gray-900 border border-gray-200');
  }

  if (isVisible.value) {
    classes.push('opacity-100 visible');
  } else {
    classes.push('opacity-0 invisible');
  }

  return classes.join(' ');
});

const arrowClasses = computed<string>(() => {
  const classes: string[] = ['absolute w-2 h-2 transform rotate-45'];

  if (props.theme === 'dark') {
    classes.push('bg-gray-900');
  } else {
    classes.push('bg-white border-l border-t border-gray-200');
  }

  switch (props.placement) {
    case 'top':
      classes.push('top-full left-1/2 -translate-x-1/2 -translate-y-1/2');
      break;
    case 'bottom':
      classes.push('bottom-full left-1/2 -translate-x-1/2 translate-y-1/2');
      break;
    case 'left':
      classes.push('left-full top-1/2 -translate-y-1/2 -translate-x-1/2');
      break;
    case 'right':
      classes.push('right-full top-1/2 -translate-y-1/2 translate-x-1/2');
      break;
  }

  return classes.join(' ');
});

const tooltipPosition = computed<string>(() => {
  const classes: string[] = [];

  switch (props.placement) {
    case 'top':
      classes.push('bottom-full left-1/2 -translate-x-1/2 mb-2');
      break;
    case 'bottom':
      classes.push('top-full left-1/2 -translate-x-1/2 mt-2');
      break;
    case 'left':
      classes.push('right-full top-1/2 -translate-y-1/2 mr-2');
      break;
    case 'right':
      classes.push('left-full top-1/2 -translate-y-1/2 ml-2');
      break;
  }

  return classes.join(' ');
});

const showTooltip = (): void => {
  if (props.disabled) return;

  if (hideTimeout) {
    clearTimeout(hideTimeout);
    hideTimeout = null;
  }

  if (props.delay > 0) {
    showTimeout = setTimeout(() => {
      isVisible.value = true;
      emit('show');
    }, props.delay);
  } else {
    isVisible.value = true;
    emit('show');
  }
};

const hideTooltip = (): void => {
  if (showTimeout) {
    clearTimeout(showTimeout);
    showTimeout = null;
  }

  hideTimeout = setTimeout(() => {
    isVisible.value = false;
    emit('hide');
  }, 100);
};

const handleMouseEnter = (): void => {
  showTooltip();
};

const handleMouseLeave = (): void => {
  hideTooltip();
};

const handleFocus = (): void => {
  showTooltip();
};

const handleBlur = (): void => {
  hideTooltip();
};

onMounted(() => {
  if (triggerRef.value) {
    triggerRef.value.addEventListener('mouseenter', handleMouseEnter);
    triggerRef.value.addEventListener('mouseleave', handleMouseLeave);
    triggerRef.value.addEventListener('focus', handleFocus);
    triggerRef.value.addEventListener('blur', handleBlur);
  }
});

onBeforeUnmount(() => {
  if (triggerRef.value) {
    triggerRef.value.removeEventListener('mouseenter', handleMouseEnter);
    triggerRef.value.removeEventListener('mouseleave', handleMouseLeave);
    triggerRef.value.removeEventListener('focus', handleFocus);
    triggerRef.value.removeEventListener('blur', handleBlur);
  }

  if (showTimeout) {
    clearTimeout(showTimeout);
  }
  if (hideTimeout) {
    clearTimeout(hideTimeout);
  }
});
</script>

<template>
  <div class="relative inline-block">
    <div ref="triggerRef" class="cursor-help">
      <slot />
    </div>

    <div ref="tooltipRef" :class="[tooltipClasses, tooltipPosition]" role="tooltip">
      {{ content }}
      <div v-if="arrow" :class="arrowClasses" />
    </div>
  </div>
</template>
