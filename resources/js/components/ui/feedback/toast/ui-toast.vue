<script setup lang="ts">
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { X, Info, CheckCircle, AlertTriangle, AlertCircle } from 'lucide-vue-next';
import type { UiToastProps as Props, UiToastEmits as Emits } from './ui-toast';

const props = withDefaults(defineProps<Props>(), {
  variant: 'info',
  position: 'top-right',
  duration: 5000,
  dismissible: true,
  show: true,
  persistent: false,
});

const emit = defineEmits<Emits>();

const isVisible = ref(props.show);
let timeoutId: number | null = null;

const toastClasses = computed<string>(() => {
  const classes: string[] = [
    'fixed z-50 max-w-sm w-full',
    'bg-white border rounded-lg shadow-lg',
    'p-4 flex items-start gap-3',
    'transform transition-all duration-300 ease-in-out',
  ];

  if (isVisible.value) {
    classes.push('translate-x-0 opacity-100');
  } else {
    switch (props.position) {
      case 'top-right':
      case 'bottom-right':
        classes.push('translate-x-full opacity-0');
        break;
      case 'top-left':
      case 'bottom-left':
        classes.push('-translate-x-full opacity-0');
        break;
      case 'top-center':
        classes.push('-translate-y-full opacity-0');
        break;
      case 'bottom-center':
        classes.push('translate-y-full opacity-0');
        break;
    }
  }

  switch (props.position) {
    case 'top-right':
      classes.push('top-4 right-4');
      break;
    case 'top-left':
      classes.push('top-4 left-4');
      break;
    case 'bottom-right':
      classes.push('bottom-4 right-4');
      break;
    case 'bottom-left':
      classes.push('bottom-4 left-4');
      break;
    case 'top-center':
      classes.push('top-4 left-1/2 -translate-x-1/2');
      break;
    case 'bottom-center':
      classes.push('bottom-4 left-1/2 -translate-x-1/2');
      break;
  }

  switch (props.variant) {
    case 'info':
      classes.push('border-blue-200');
      break;
    case 'success':
      classes.push('border-green-200');
      break;
    case 'warning':
      classes.push('border-yellow-200');
      break;
    case 'error':
      classes.push('border-red-200');
      break;
  }

  return classes.join(' ');
});

const iconClasses = computed<string>(() => {
  const classes: string[] = ['flex-shrink-0 w-5 h-5'];

  switch (props.variant) {
    case 'info':
      classes.push('text-blue-500');
      break;
    case 'success':
      classes.push('text-green-500');
      break;
    case 'warning':
      classes.push('text-yellow-500');
      break;
    case 'error':
      classes.push('text-red-500');
      break;
  }

  return classes.join(' ');
});

const titleClasses = computed<string>(() => {
  const classes: string[] = ['font-medium text-sm'];

  switch (props.variant) {
    case 'info':
      classes.push('text-blue-800');
      break;
    case 'success':
      classes.push('text-green-800');
      break;
    case 'warning':
      classes.push('text-yellow-800');
      break;
    case 'error':
      classes.push('text-red-800');
      break;
  }

  return classes.join(' ');
});

const defaultIcon = computed(() => {
  switch (props.variant) {
    case 'info':
      return Info;
    case 'success':
      return CheckCircle;
    case 'warning':
      return AlertTriangle;
    case 'error':
      return AlertCircle;
    default:
      return Info;
  }
});

const handleDismiss = (): void => {
  isVisible.value = false;
  if (timeoutId) {
    clearTimeout(timeoutId);
    timeoutId = null;
  }

  setTimeout(() => {
    emit('close');
    emit('dismiss');
  }, 300);
};

const startTimer = (): void => {
  if (!props.persistent && props.duration > 0) {
    timeoutId = window.setTimeout(() => {
      handleDismiss();
    }, props.duration);
  }
};

const pauseTimer = (): void => {
  if (timeoutId) {
    clearTimeout(timeoutId);
    timeoutId = null;
  }
};

const resumeTimer = (): void => {
  startTimer();
};

onMounted(() => {
  if (props.show) {
    startTimer();
  }
});

onUnmounted(() => {
  if (timeoutId) {
    clearTimeout(timeoutId);
  }
});
</script>

<template>
  <teleport to="body">
    <div
      v-if="isVisible || $slots.default"
      :class="toastClasses"
      role="alert"
      @mouseenter="pauseTimer"
      @mouseleave="resumeTimer"
    >
      <component :is="icon || defaultIcon" :class="iconClasses" />

      <div class="flex-1 min-w-0">
        <h4 v-if="title" :class="titleClasses">
          {{ title }}
        </h4>

        <div v-if="description" class="text-gray-600 text-sm mt-1">
          {{ description }}
        </div>

        <div v-else-if="$slots.default" class="text-gray-600 text-sm mt-1">
          <slot />
        </div>
      </div>

      <button
        v-if="dismissible"
        type="button"
        class="flex-shrink-0 p-0.5 hover:bg-gray-100 rounded transition-colors text-gray-400 hover:text-gray-600"
        @click="handleDismiss"
      >
        <x class="w-4 h-4" />
      </button>
    </div>
  </teleport>
</template>
