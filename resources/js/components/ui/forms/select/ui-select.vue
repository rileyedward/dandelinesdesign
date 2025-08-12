<script setup lang="ts">
import { computed, ref } from 'vue';
import { ChevronDown } from 'lucide-vue-next';
import type { UiSelectProps as Props, UiSelectEmits as Emits } from './ui-select';

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
  size: 'md',
  fullWidth: false,
  disabled: false,
  required: false,
  multiple: false,
  searchable: false,
});

const emit = defineEmits<Emits>();

const isOpen = ref(false);

const selectClasses = computed<string>(() => {
  const classes: string[] = [
    'w-full border transition-colors duration-200 cursor-pointer',
    'focus:outline-none focus:ring-2 focus:ring-offset-1',
    'disabled:pointer-events-none disabled:opacity-50 disabled:cursor-not-allowed',
    'flex items-center justify-between',
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

const dropdownClasses = computed<string>(() => {
  const classes: string[] = [
    'absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg',
    'max-h-60 overflow-auto',
  ];

  return classes.join(' ');
});

const selectedOption = computed(() => {
  return props.options.find(option => option.value === props.modelValue);
});

const displayValue = computed(() => {
  return selectedOption.value?.label || props.placeholder || 'Select an option';
});

const handleSelect = (value: string | number): void => {
  if (!props.disabled) {
    emit('update:modelValue', value);
    emit('change', value);
    isOpen.value = false;
  }
};

const toggleDropdown = (): void => {
  if (!props.disabled) {
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
      emit('open');
    } else {
      emit('close');
    }
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
    setTimeout(() => {
      isOpen.value = false;
      emit('close');
    }, 150);
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
      <button
        type="button"
        :class="selectClasses"
        :disabled="disabled"
        @click="toggleDropdown"
        @focus="handleFocus"
        @blur="handleBlur"
      >
        <component
          :is="prefixIcon"
          v-if="prefixIcon"
          :class="[iconClasses, 'text-gray-400 mr-2']"
        />

        <span :class="['flex-1 text-left', !selectedOption ? 'text-gray-400' : 'text-gray-900']">
          {{ displayValue }}
        </span>

        <component
          :is="suffixIcon"
          v-if="suffixIcon"
          :class="[iconClasses, 'text-gray-400 ml-2']"
        />
        <chevron-down
          v-else
          :class="[
            iconClasses,
            'text-gray-400 ml-2 transition-transform duration-200',
            isOpen ? 'transform rotate-180' : '',
          ]"
        />
      </button>

      <div v-if="isOpen" :class="dropdownClasses">
        <button
          v-for="option in options"
          :key="option.value"
          type="button"
          :disabled="option.disabled"
          :class="[
            'w-full text-left px-4 py-2 hover:bg-gray-100 focus:bg-gray-100',
            'focus:outline-none transition-colors duration-150',
            option.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
            option.value === modelValue ? 'bg-purple-50 text-purple-700' : 'text-gray-900',
          ]"
          @click="handleSelect(option.value)"
        >
          {{ option.label }}
        </button>
      </div>
    </div>

    <p v-if="helperText && !errorText" class="mt-1 text-sm text-gray-500">
      {{ helperText }}
    </p>

    <p v-if="errorText" class="mt-1 text-sm text-red-600">
      {{ errorText }}
    </p>
  </div>
</template>
