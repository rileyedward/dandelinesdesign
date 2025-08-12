<script setup lang="ts">
import { computed } from 'vue';
import type { UiTextareaProps as Props, UiTextareaEmits as Emits } from './ui-textarea';

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
  size: 'md',
  fullWidth: false,
  disabled: false,
  readonly: false,
  required: false,
  rows: 4,
  resize: 'vertical',
});

const emit = defineEmits<Emits>();

const textareaClasses = computed<string>(() => {
  const classes: string[] = [
    'w-full border transition-colors duration-200',
    'focus:outline-none focus:ring-2 focus:ring-offset-1',
    'disabled:pointer-events-none disabled:opacity-50',
    'placeholder:text-gray-400',
  ];

  switch (props.variant) {
    case 'default':
      classes.push(
        'border-gray-300 bg-white',
        'hover:border-gray-400',
        'focus:border-purple-500 focus:ring-purple-500'
      );
      break;
    case 'outlined':
      classes.push(
        'border-gray-300 bg-transparent',
        'hover:border-gray-400',
        'focus:border-purple-500 focus:ring-purple-500'
      );
      break;
    case 'filled':
      classes.push(
        'border-gray-200 bg-gray-50',
        'hover:bg-gray-100 hover:border-gray-300',
        'focus:bg-white focus:border-purple-500 focus:ring-purple-500'
      );
      break;
  }

  switch (props.size) {
    case 'sm':
      classes.push('p-2 text-sm rounded-md');
      break;
    case 'md':
      classes.push('p-3 text-sm rounded-md');
      break;
    case 'lg':
      classes.push('p-4 text-base rounded-lg');
      break;
  }

  switch (props.resize) {
    case 'none':
      classes.push('resize-none');
      break;
    case 'both':
      classes.push('resize');
      break;
    case 'horizontal':
      classes.push('resize-x');
      break;
    case 'vertical':
      classes.push('resize-y');
      break;
  }

  if (props.errorText) {
    classes.push('border-red-300 bg-red-50', 'focus:border-red-500 focus:ring-red-500');
  }

  return classes.join(' ');
});

const wrapperClasses = computed<string>(() => {
  const classes: string[] = ['relative'];

  if (props.fullWidth) {
    classes.push('w-full');
  }

  return classes.join(' ');
});

const handleInput = (event: Event): void => {
  const target = event.target as HTMLTextAreaElement;
  emit('update:modelValue', target.value);
  emit('input', event);
};

const handleChange = (event: Event): void => {
  emit('change', event);
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
  <div :class="wrapperClasses">
    <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }}
      <span v-if="required" class="text-red-500 ml-1">*</span>
    </label>

    <textarea
      :value="modelValue"
      :placeholder="placeholder"
      :disabled="disabled"
      :readonly="readonly"
      :required="required"
      :rows="rows"
      :cols="cols"
      :maxlength="maxLength"
      :minlength="minLength"
      :autocomplete="autocomplete"
      :class="textareaClasses"
      @input="handleInput"
      @change="handleChange"
      @focus="handleFocus"
      @blur="handleBlur"
      @keyup="handleKeyup"
      @keydown="handleKeydown"
    />

    <p v-if="helperText && !errorText" class="mt-1 text-sm text-gray-500">
      {{ helperText }}
    </p>

    <p v-if="errorText" class="mt-1 text-sm text-red-600">
      {{ errorText }}
    </p>
  </div>
</template>
