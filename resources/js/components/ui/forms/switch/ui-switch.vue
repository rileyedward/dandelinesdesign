<script setup lang="ts">
import { computed } from 'vue';
import type { UiSwitchProps as Props, UiSwitchEmits as Emits } from './ui-switch';

const props = withDefaults(defineProps<Props>(), {
  disabled: false,
  size: 'md',
  color: 'primary',
});

const emit = defineEmits<Emits>();

const toggle = () => {
  if (props.disabled) return;

  const newValue = !props.modelValue;
  emit('update:modelValue', newValue);
  emit('change', newValue);
};

const containerClasses = computed(() => {
  return [
    'inline-flex items-center',
    props.disabled ? 'opacity-60 cursor-not-allowed' : 'cursor-pointer',
  ].join(' ');
});

const switchClasses = computed(() => {
  const baseClasses = [
    'relative inline-flex flex-shrink-0 border-2 border-transparent rounded-full',
    'transition-colors ease-in-out duration-200',
    'focus:outline-none focus:ring-2 focus:ring-offset-2',
  ];

  if (props.size === 'sm') {
    baseClasses.push('h-5 w-9');
  } else if (props.size === 'lg') {
    baseClasses.push('h-7 w-14');
  } else {
    baseClasses.push('h-6 w-11');
  }

  if (props.modelValue) {
    switch (props.color) {
      case 'success':
        baseClasses.push('bg-green-500 focus:ring-green-500');
        break;
      case 'danger':
        baseClasses.push('bg-red-500 focus:ring-red-500');
        break;
      case 'warning':
        baseClasses.push('bg-yellow-500 focus:ring-yellow-500');
        break;
      case 'info':
        baseClasses.push('bg-blue-500 focus:ring-blue-500');
        break;
      default:
        baseClasses.push('bg-purple-500 focus:ring-purple-500');
        break;
    }
  } else {
    baseClasses.push('bg-gray-200');
  }

  if (props.disabled) {
    baseClasses.push('cursor-not-allowed');
  }

  return baseClasses.join(' ');
});

const thumbClasses = computed(() => {
  const baseClasses = [
    'pointer-events-none inline-block rounded-full bg-white shadow transform',
    'transition ease-in-out duration-200',
  ];

  if (props.size === 'sm') {
    baseClasses.push('h-4 w-4');
    baseClasses.push(props.modelValue ? 'translate-x-4' : 'translate-x-0');
  } else if (props.size === 'lg') {
    baseClasses.push('h-6 w-6');
    baseClasses.push(props.modelValue ? 'translate-x-7' : 'translate-x-0');
  } else {
    baseClasses.push('h-5 w-5');
    baseClasses.push(props.modelValue ? 'translate-x-5' : 'translate-x-0');
  }

  return baseClasses.join(' ');
});

const textClasses = computed(() => {
  const baseClasses = ['text-sm'];

  if (props.size === 'sm') {
    baseClasses.push('text-xs');
  } else if (props.size === 'lg') {
    baseClasses.push('text-base');
  }

  return baseClasses.join(' ');
});

const iconClasses = computed(() => {
  if (props.size === 'sm') {
    return 'h-3 w-3';
  } else if (props.size === 'lg') {
    return 'h-5 w-5';
  }
  return 'h-4 w-4';
});
</script>

<template>
  <div class="w-full">
    <div v-if="label" class="mb-2 text-sm font-medium text-gray-700">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </div>

    <div :class="containerClasses" @click="toggle">
      <div v-if="leftText || leftIcon" class="mr-2">
        <component :is="leftIcon" v-if="leftIcon" :class="iconClasses" />
        <span v-else-if="leftText" :class="textClasses">{{ leftText }}</span>
      </div>

      <!-- Switch -->
      <button
        type="button"
        role="switch"
        :aria-checked="modelValue"
        :disabled="disabled"
        :class="switchClasses"
        @click.stop="toggle"
      >
        <span aria-hidden="true" :class="thumbClasses"></span>
      </button>

      <div v-if="rightText || rightIcon" class="ml-2">
        <component :is="rightIcon" v-if="rightIcon" :class="iconClasses" />
        <span v-else-if="rightText" :class="textClasses">{{ rightText }}</span>
      </div>
    </div>

    <div v-if="helperText && !error" class="mt-1 text-xs text-gray-500">
      {{ helperText }}
    </div>
    <div v-if="error" class="mt-1 text-xs text-red-500">
      {{ error }}
    </div>
  </div>
</template>
