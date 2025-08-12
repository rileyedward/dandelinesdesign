<script setup lang="ts">
import { computed } from 'vue';
import type { UiCardProps as Props, UiCardEmits as Emits } from './ui-card';

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
  size: 'md',
  padding: 'md',
  rounded: 'md',
  shadow: 'sm',
  hover: false,
  clickable: false,
  loading: false,
  disabled: false,
});

const emit = defineEmits<Emits>();

const cardClasses = computed<string>(() => {
  const classes: string[] = ['transition-all duration-200'];

  switch (props.variant) {
    case 'default':
      classes.push('bg-white border border-gray-200');
      break;
    case 'outlined':
      classes.push('bg-white border-2 border-gray-300');
      break;
    case 'elevated':
      classes.push('bg-white border border-gray-100');
      break;
    case 'filled':
      classes.push('bg-gray-50 border border-gray-200');
      break;
  }

  switch (props.rounded) {
    case 'none':
      classes.push('rounded-none');
      break;
    case 'sm':
      classes.push('rounded-sm');
      break;
    case 'md':
      classes.push('rounded-md');
      break;
    case 'lg':
      classes.push('rounded-lg');
      break;
    case 'full':
      classes.push('rounded-full');
      break;
  }

  switch (props.shadow) {
    case 'none':
      classes.push('shadow-none');
      break;
    case 'sm':
      classes.push('shadow-sm');
      break;
    case 'md':
      classes.push('shadow-md');
      break;
    case 'lg':
      classes.push('shadow-lg');
      break;
    case 'xl':
      classes.push('shadow-xl');
      break;
  }

  if (props.clickable && !props.disabled) {
    classes.push('cursor-pointer');
  }

  if (props.hover && !props.disabled) {
    classes.push('hover:shadow-md hover:-translate-y-0.5');
  }

  if (props.disabled) {
    classes.push('opacity-60 cursor-not-allowed');
  }

  if (props.loading) {
    classes.push('animate-pulse');
  }

  return classes.join(' ');
});

const contentClasses = computed<string>(() => {
  const classes: string[] = [];

  switch (props.padding) {
    case 'none':
      classes.push('p-0');
      break;
    case 'sm':
      classes.push('p-3');
      break;
    case 'md':
      classes.push('p-4');
      break;
    case 'lg':
      classes.push('p-6');
      break;
  }

  return classes.join(' ');
});

const handleClick = (event: MouseEvent): void => {
  if (!props.disabled && !props.loading) {
    emit('click', event);
  }
};
</script>

<template>
  <div :class="cardClasses" @click="clickable ? handleClick($event) : undefined">
    <div v-if="$slots.header" class="border-b border-gray-200">
      <div :class="contentClasses">
        <slot name="header" />
      </div>
    </div>

    <div v-if="$slots.media" class="overflow-hidden">
      <slot name="media" />
    </div>

    <div :class="contentClasses">
      <slot />
    </div>

    <div v-if="$slots.footer" class="border-t border-gray-200">
      <div :class="contentClasses">
        <slot name="footer" />
      </div>
    </div>

    <div v-if="$slots.actions" class="border-t border-gray-200 px-4 py-3">
      <div class="flex items-center justify-end gap-3">
        <slot name="actions" />
      </div>
    </div>
  </div>
</template>
