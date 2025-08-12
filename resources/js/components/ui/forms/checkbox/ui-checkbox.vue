<script setup lang="ts">
import { computed } from 'vue';
import { Check, Minus } from 'lucide-vue-next';
import type { UiCheckboxProps as Props, UiCheckboxEmits as Emits } from './ui-checkbox';

const props = withDefaults(defineProps<Props>(), {
  modelValue: false,
  variant: 'default',
  size: 'md',
  disabled: false,
  required: false,
  indeterminate: false,
});

const emit = defineEmits<Emits>();

const checkboxClasses = computed<string>(() => {
  const classes: string[] = [
    'relative inline-flex items-center justify-center',
    'border-2 transition-all duration-200',
    'focus:outline-none focus:ring-2 focus:ring-offset-2',
    'disabled:opacity-50 disabled:cursor-not-allowed',
    'cursor-pointer',
  ];

  switch (props.variant) {
    case 'default':
      if (props.modelValue || props.indeterminate) {
        classes.push(
          'bg-purple-500 border-purple-500 text-white',
          'hover:bg-purple-600 hover:border-purple-600',
          'focus:ring-purple-500'
        );
      } else {
        classes.push('bg-white border-gray-300', 'hover:border-gray-400', 'focus:ring-purple-500');
      }
      break;
    case 'outlined':
      if (props.modelValue || props.indeterminate) {
        classes.push(
          'bg-transparent border-purple-500 text-purple-500',
          'hover:bg-purple-50',
          'focus:ring-purple-500'
        );
      } else {
        classes.push(
          'bg-transparent border-gray-300',
          'hover:border-gray-400',
          'focus:ring-purple-500'
        );
      }
      break;
  }

  switch (props.size) {
    case 'sm':
      classes.push('w-4 h-4 rounded');
      break;
    case 'md':
      classes.push('w-5 h-5 rounded');
      break;
    case 'lg':
      classes.push('w-6 h-6 rounded-md');
      break;
  }

  if (props.errorText) {
    classes.push('border-red-500', 'focus:ring-red-500');
  }

  return classes.join(' ');
});

const iconSize = computed(() => {
  return {
    'w-2.5 h-2.5': props.size === 'sm',
    'w-3 h-3': props.size === 'md',
    'w-4 h-4': props.size === 'lg',
  };
});

const labelClasses = computed<string>(() => {
  const classes: string[] = ['flex items-start gap-3'];

  if (props.disabled) {
    classes.push('cursor-not-allowed');
  } else {
    classes.push('cursor-pointer');
  }

  return classes.join(' ');
});

const textClasses = computed<string>(() => {
  const classes: string[] = [];

  switch (props.size) {
    case 'sm':
      classes.push('text-sm');
      break;
    case 'md':
      classes.push('text-base');
      break;
    case 'lg':
      classes.push('text-lg');
      break;
  }

  if (props.disabled) {
    classes.push('text-gray-400');
  } else {
    classes.push('text-gray-900');
  }

  return classes.join(' ');
});

const handleChange = (event: Event): void => {
  if (!props.disabled) {
    const newValue = !props.modelValue;
    emit('update:modelValue', newValue);
    emit('change', newValue, event);
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
</script>

<template>
  <label :class="labelClasses">
    <input
      type="checkbox"
      :checked="modelValue"
      :disabled="disabled"
      :required="required"
      :value="value"
      class="sr-only"
      @change="handleChange"
      @focus="handleFocus"
      @blur="handleBlur"
    />

    <div :class="checkboxClasses">
      <check v-if="modelValue && !indeterminate" :class="iconSize" />

      <minus v-else-if="indeterminate" :class="iconSize" />
    </div>

    <div v-if="label || description" class="flex-1 min-w-0">
      <div v-if="label" :class="textClasses">
        {{ label }}
        <span v-if="required" class="text-red-500 ml-1">*</span>
      </div>
      <div v-if="description" class="text-sm text-gray-500 mt-1">
        {{ description }}
      </div>
      <div v-if="errorText" class="text-sm text-red-600 mt-1">
        {{ errorText }}
      </div>
    </div>
  </label>
</template>
