<script setup lang="ts">
import { computed } from 'vue';
import type { UiInputProps as Props, UiInputEmits as Emits } from './ui-input';

const props = withDefaults(defineProps<Props>(), {
  type: 'text',
  variant: 'default',
  size: 'md',
  fullWidth: false,
  disabled: false,
  readonly: false,
  required: false,
});

const emit = defineEmits<Emits>();

const inputClasses = computed<string>(() => {
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
      classes.push('h-8 px-3 text-sm rounded-md');
      break;
    case 'md':
      classes.push('h-9 px-4 text-sm rounded-md');
      break;
    case 'lg':
      classes.push('h-10 px-4 text-base rounded-lg');
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

const iconClasses = computed<string>(() => {
  return {
    'h-3 w-3': props.size === 'sm',
    'h-4 w-4': props.size === 'md',
    'h-5 w-5': props.size === 'lg',
  };
});

const handleInput = (event: Event): void => {
  const target = event.target as HTMLInputElement;
  const value = props.type === 'number' ? Number(target.value) : target.value;
  emit('update:modelValue', value);
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
    if (event.key === 'Enter') {
      emit('enter', event);
    }
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

    <div class="relative">
      <component
        :is="prefixIcon"
        v-if="prefixIcon"
        :class="[
          iconClasses,
          'absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none',
        ]"
      />

      <input
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        :required="required"
        :maxlength="maxLength"
        :minlength="minLength"
        :min="min"
        :max="max"
        :step="step"
        :autocomplete="autocomplete"
        :class="[
          inputClasses,
          prefixIcon ? (size === 'sm' ? 'pl-9' : size === 'md' ? 'pl-10' : 'pl-12') : '',
          suffixIcon ? (size === 'sm' ? 'pr-9' : size === 'md' ? 'pr-10' : 'pr-12') : '',
        ]"
        @input="handleInput"
        @change="handleChange"
        @focus="handleFocus"
        @blur="handleBlur"
        @keyup="handleKeyup"
        @keydown="handleKeydown"
      />

      <component
        :is="suffixIcon"
        v-if="suffixIcon"
        :class="[
          iconClasses,
          'absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none',
        ]"
      />
    </div>

    <p v-if="helperText && !errorText" class="mt-1 text-sm text-gray-500">
      {{ helperText }}
    </p>

    <p v-if="errorText" class="mt-1 text-sm text-red-600">
      {{ errorText }}
    </p>
  </div>
</template>
