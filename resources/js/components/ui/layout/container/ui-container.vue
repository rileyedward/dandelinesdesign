<script setup lang="ts">
import { computed } from 'vue';
import type { UiContainerProps as Props } from './ui-container';

const props = withDefaults(defineProps<Props>(), {
  size: 'lg',
  padding: 'md',
  margin: 'none',
  centered: false,
  fluid: false,
  as: 'div',
});

const containerClasses = computed<string>(() => {
  const classes: string[] = [];

  if (props.fluid) {
    classes.push('w-full');
  } else {
    switch (props.size) {
      case 'sm':
        classes.push('max-w-sm');
        break;
      case 'md':
        classes.push('max-w-md');
        break;
      case 'lg':
        classes.push('max-w-4xl');
        break;
      case 'xl':
        classes.push('max-w-6xl');
        break;
      case '2xl':
        classes.push('max-w-7xl');
        break;
      case 'full':
        classes.push('max-w-full');
        break;
    }
  }

  switch (props.padding) {
    case 'none':
      classes.push('p-0');
      break;
    case 'sm':
      classes.push('p-2');
      break;
    case 'md':
      classes.push('p-4');
      break;
    case 'lg':
      classes.push('p-6');
      break;
    case 'xl':
      classes.push('p-8');
      break;
  }

  switch (props.margin) {
    case 'none':
      classes.push('m-0');
      break;
    case 'sm':
      classes.push('m-2');
      break;
    case 'md':
      classes.push('m-4');
      break;
    case 'lg':
      classes.push('m-6');
      break;
    case 'xl':
      classes.push('m-8');
      break;
    case 'auto':
      classes.push('mx-auto');
      break;
  }

  if (props.centered) {
    classes.push('mx-auto');
  }

  return classes.join(' ');
});
</script>

<template>
  <component :is="as" :class="containerClasses">
    <slot />
  </component>
</template>
