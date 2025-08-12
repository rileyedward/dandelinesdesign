<script setup lang="ts">
import { computed } from 'vue';
import type { UiButtonProps as Props, UiButtonEmits as Emits } from './ui-button';

const props = withDefaults(defineProps<Props>(), {
  type: 'button',
  variant: 'primary',
  size: 'md',
  fullWidth: false,
  disabled: false,
  loading: false,
});

const emit = defineEmits<Emits>();

const buttonClasses = computed<string>(() => {
  const classes: string[] = [
    'inline-flex items-center justify-center gap-2',
    'font-medium text-sm',
    'border border-transparent',
    'transition-colors duration-200',
    'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2',
    'disabled:pointer-events-none disabled:opacity-50',
    'select-none',
  ];

  switch (props.variant) {
    case 'primary':
      classes.push(
        'bg-purple-500 text-white',
        'hover:bg-purple-600 active:bg-purple-700',
        'focus-visible:ring-purple-500'
      );
      break;
    case 'secondary':
      classes.push(
        'bg-gray-500 text-white',
        'hover:bg-gray-600 active:bg-gray-700',
        'focus-visible:ring-gray-500'
      );
      break;
    case 'outline':
      classes.push(
        'border-gray-300 bg-transparent text-gray-700',
        'hover:bg-gray-50 active:bg-gray-100',
        'focus-visible:ring-gray-500'
      );
      break;
    case 'success':
      classes.push(
        'bg-green-500 text-white',
        'hover:bg-green-600 active:bg-green-700',
        'focus-visible:ring-green-500'
      );
      break;
    case 'danger':
      classes.push(
        'bg-red-500 text-white',
        'hover:bg-red-600 active:bg-red-700',
        'focus-visible:ring-red-500'
      );
      break;
    case 'warning':
      classes.push(
        'bg-yellow-500 text-white',
        'hover:bg-yellow-600 active:bg-yellow-700',
        'focus-visible:ring-yellow-500'
      );
      break;
    case 'info':
      classes.push(
        'bg-blue-500 text-white',
        'hover:bg-blue-600 active:bg-blue-700',
        'focus-visible:ring-blue-500'
      );
      break;
  }

  switch (props.size) {
    case 'sm':
      classes.push('h-8 px-3 text-xs rounded-md');
      break;
    case 'md':
      classes.push('h-9 px-4 text-sm rounded-md');
      break;
    case 'lg':
      classes.push('h-10 px-6 text-base rounded-lg');
      break;
    case 'xl':
      classes.push('h-12 px-8 text-lg rounded-lg');
      break;
  }

  if (props.fullWidth) {
    classes.push('w-full');
  }

  return classes.join(' ');
});

const handleClick = (event: MouseEvent): void => {
  if (!props.disabled && !props.loading) {
    emit('click', event);
  }
};

const handleFocus = (event: FocusEvent): void => {
  if (!props.disabled) {
    emit('focus', event);
  }
};

const handleBlur = (event: FocusEvent): void => {
  if (!props.disabled) {
    emit('blur', event);
  }
};

const handleKeyup = (event: KeyboardEvent): void => {
  if (!props.disabled) {
    emit('keyup', event);
  }
};

const handleKeydown = (event: KeyboardEvent): void => {
  if (!props.disabled) {
    emit('keydown', event);
  }
};
</script>

<template>
  <button
    :type="type"
    :class="buttonClasses"
    :disabled="disabled || loading"
    @click="handleClick"
    @focus="handleFocus"
    @blur="handleBlur"
    @keyup="handleKeyup"
    @keydown="handleKeydown"
  >
    <component
      :is="prefixIcon"
      v-if="prefixIcon && !loading"
      :class="{
        'h-3 w-3': size === 'sm',
        'h-4 w-4': size === 'md',
        'h-5 w-5': size === 'lg',
        'h-6 w-6': size === 'xl',
      }"
    />

    <div
      v-if="loading"
      :class="{
        'h-3 w-3': size === 'sm',
        'h-4 w-4': size === 'md',
        'h-5 w-5': size === 'lg',
        'h-6 w-6': size === 'xl',
      }"
      class="animate-spin rounded-full border-2 border-current border-t-transparent"
    />

    <span v-if="label || $slots.default">
      <slot>{{ label }}</slot>
    </span>

    <component
      :is="suffixIcon"
      v-if="suffixIcon && !loading"
      :class="{
        'h-3 w-3': size === 'sm',
        'h-4 w-4': size === 'md',
        'h-5 w-5': size === 'lg',
        'h-6 w-6': size === 'xl',
      }"
    />
  </button>
</template>
