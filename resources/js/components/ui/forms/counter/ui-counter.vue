<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import type { UiCounterProps as Props, UiCounterEmits as Emits } from './ui-counter';
import { Plus, Minus } from 'lucide-vue-next';

const props = withDefaults(defineProps<Props>(), {
  min: 0,
  max: 100,
  step: 1,
  disabled: false,
  size: 'md',
});

const emit = defineEmits<Emits>();

const localValue = ref(props.modelValue);

watch(
  () => props.modelValue,
  newValue => {
    localValue.value = newValue;
  }
);

const increment = () => {
  if (props.disabled) return;

  const newValue = Math.min(props.max, localValue.value + props.step);
  if (newValue !== localValue.value) {
    updateValue(newValue);
    emit('increment');
  }
};

const decrement = () => {
  if (props.disabled) return;

  const newValue = Math.max(props.min, localValue.value - props.step);
  if (newValue !== localValue.value) {
    updateValue(newValue);
    emit('decrement');
  }
};

const updateValue = (value: number) => {
  localValue.value = value;
  emit('update:modelValue', value);
  emit('change', value);
};

const containerClasses = computed(() => {
  const classes = [
    'inline-flex items-center border rounded-md',
    props.disabled ? 'opacity-50 cursor-not-allowed' : '',
  ];

  return classes.join(' ');
});

const buttonClasses = computed(() => {
  const classes = [
    'flex items-center justify-center',
    'text-gray-700 bg-gray-100 hover:bg-gray-200',
    'border-0 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2',
    props.disabled ? 'cursor-not-allowed' : 'cursor-pointer',
  ];

  switch (props.size) {
    case 'sm':
      classes.push('h-7 w-7');
      break;
    case 'md':
      classes.push('h-8 w-8');
      break;
    case 'lg':
      classes.push('h-9 w-9');
      break;
    case 'xl':
      classes.push('h-10 w-10');
      break;
  }

  return classes.join(' ');
});

const valueClasses = computed(() => {
  const classes = ['flex items-center justify-center', 'px-3 text-center', 'border-x'];

  switch (props.size) {
    case 'sm':
      classes.push('h-7 min-w-[2rem] text-xs');
      break;
    case 'md':
      classes.push('h-8 min-w-[2.5rem] text-sm');
      break;
    case 'lg':
      classes.push('h-9 min-w-[3rem]');
      break;
    case 'xl':
      classes.push('h-10 min-w-[3.5rem] text-lg');
      break;
  }

  return classes.join(' ');
});

const iconSize = computed(() => {
  switch (props.size) {
    case 'sm':
      return 'h-3 w-3';
    case 'md':
      return 'h-4 w-4';
    case 'lg':
      return 'h-5 w-5';
    case 'xl':
      return 'h-6 w-6';
    default:
      return 'h-4 w-4';
  }
});
</script>

<template>
  <div class="w-full">
    <div v-if="label" class="mb-2 text-sm font-medium text-gray-700">
      {{ label }}
    </div>

    <div :class="containerClasses">
      <button
        type="button"
        :class="buttonClasses"
        :disabled="disabled || localValue <= min"
        @click="decrement"
      >
        <minus :class="iconSize" />
      </button>

      <div :class="valueClasses">
        {{ localValue }}
      </div>

      <button
        type="button"
        :class="buttonClasses"
        :disabled="disabled || localValue >= max"
        @click="increment"
      >
        <plus :class="iconSize" />
      </button>
    </div>
  </div>
</template>
