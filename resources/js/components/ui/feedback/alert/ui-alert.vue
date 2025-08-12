<script setup lang="ts">
import { computed, ref } from 'vue';
import { X, Info, CheckCircle, AlertTriangle, AlertCircle } from 'lucide-vue-next';
import type { UiAlertProps as Props, UiAlertEmits as Emits } from './ui-alert';

const props = withDefaults(defineProps<Props>(), {
  variant: 'info',
  size: 'md',
  dismissible: false,
  show: true,
});

const emit = defineEmits<Emits>();

const isVisible = ref(props.show);

const alertClasses = computed<string>(() => {
  const classes: string[] = [
    'border rounded-lg transition-all duration-200',
    'flex items-start gap-3',
  ];

  switch (props.variant) {
    case 'info':
      classes.push('bg-blue-50 border-blue-200 text-blue-800');
      break;
    case 'success':
      classes.push('bg-green-50 border-green-200 text-green-800');
      break;
    case 'warning':
      classes.push('bg-yellow-50 border-yellow-200 text-yellow-800');
      break;
    case 'error':
      classes.push('bg-red-50 border-red-200 text-red-800');
      break;
  }

  switch (props.size) {
    case 'sm':
      classes.push('p-3 text-sm');
      break;
    case 'md':
      classes.push('p-4 text-sm');
      break;
    case 'lg':
      classes.push('p-5 text-base');
      break;
  }

  return classes.join(' ');
});

const iconClasses = computed<string>(() => {
  const classes: string[] = ['flex-shrink-0 mt-0.5'];

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

const iconSize = computed(() => {
  return {
    'w-4 h-4': props.size === 'sm',
    'w-5 h-5': props.size === 'md',
    'w-6 h-6': props.size === 'lg',
  };
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
  emit('close');
  emit('dismiss');
};
</script>

<template>
  <div v-if="isVisible" :class="alertClasses" role="alert">
    <component :is="icon || defaultIcon" :class="[iconClasses, iconSize]" />

    <div class="flex-1 min-w-0">
      <h4 v-if="title" class="font-medium mb-1">
        {{ title }}
      </h4>

      <div v-if="description" class="opacity-90">
        {{ description }}
      </div>

      <div v-else-if="$slots.default" class="opacity-90">
        <slot />
      </div>
    </div>

    <button
      v-if="dismissible"
      type="button"
      class="flex-shrink-0 p-0.5 hover:bg-black/10 rounded transition-colors"
      @click="handleDismiss"
    >
      <x :class="iconSize" />
    </button>
  </div>
</template>
