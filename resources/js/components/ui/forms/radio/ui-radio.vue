<script setup lang="ts">
import { computed } from 'vue';
import type { UiRadioProps as Props, UiRadioEmits as Emits } from './ui-radio';

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
  size: 'md',
  disabled: false,
  required: false,
});

const emit = defineEmits<Emits>();

const isSelected = computed<boolean>(() => props.modelValue === props.value);

const radioClasses = computed<string>(() => {
  const classes: string[] = [
    'relative inline-flex items-center justify-center',
    'border-2 transition-all duration-200 rounded-full',
    'focus:outline-none focus:ring-2 focus:ring-offset-2',
    'disabled:opacity-50 disabled:cursor-not-allowed',
    'cursor-pointer',
  ];

  switch (props.variant) {
    case 'default':
      if (isSelected.value) {
        classes.push(
          'bg-purple-500 border-purple-500',
          'hover:bg-purple-600 hover:border-purple-600',
          'focus:ring-purple-500'
        );
      } else {
        classes.push('bg-white border-gray-300', 'hover:border-gray-400', 'focus:ring-purple-500');
      }
      break;
    case 'outlined':
      if (isSelected.value) {
        classes.push(
          'bg-transparent border-purple-500',
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
      classes.push('w-4 h-4');
      break;
    case 'md':
      classes.push('w-5 h-5');
      break;
    case 'lg':
      classes.push('w-6 h-6');
      break;
  }

  if (props.errorText) {
    classes.push('border-red-500', 'focus:ring-red-500');
  }

  return classes.join(' ');
});

const dotClasses = computed<string>(() => {
  const classes: string[] = ['rounded-full transition-all duration-200'];

  switch (props.size) {
    case 'sm':
      classes.push('w-1.5 h-1.5');
      break;
    case 'md':
      classes.push('w-2 h-2');
      break;
    case 'lg':
      classes.push('w-2.5 h-2.5');
      break;
  }

  if (isSelected.value) {
    if (props.variant === 'default') {
      classes.push('bg-white');
    } else {
      classes.push('bg-purple-500');
    }
  } else {
    classes.push('bg-transparent');
  }

  return classes.join(' ');
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
    emit('update:modelValue', props.value);
    emit('change', props.value, event);
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
      type="radio"
      :name="name"
      :value="value"
      :checked="isSelected"
      :disabled="disabled"
      :required="required"
      class="sr-only"
      @change="handleChange"
      @focus="handleFocus"
      @blur="handleBlur"
    />

    <div :class="radioClasses">
      <div :class="dotClasses" />
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
