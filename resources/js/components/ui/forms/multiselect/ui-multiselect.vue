<script setup lang="ts">
import { computed, ref } from 'vue';
import { ChevronDown, X, Check } from 'lucide-vue-next';
import type { UiMultiSelectProps as Props, UiMultiSelectEmits as Emits } from './ui-multiselect';

const props = withDefaults(defineProps<Props>(), {
  modelValue: () => [],
  variant: 'default',
  size: 'md',
  fullWidth: false,
  disabled: false,
  required: false,
  searchable: false,
  showSelectAll: false,
});

const emit = defineEmits<Emits>();

const isOpen = ref<boolean>(false);
const searchQuery = ref<string>('');

const selectClasses = computed<string>(() => {
  const classes: string[] = [
    'w-full border transition-colors duration-200 cursor-pointer min-h-fit',
    'focus:outline-none focus:ring-2 focus:ring-offset-1',
    'disabled:pointer-events-none disabled:opacity-50 disabled:cursor-not-allowed',
    'flex flex-wrap items-center gap-2',
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
      classes.push('min-h-8 px-3 text-sm rounded-md');
      break;
    case 'md':
      classes.push('min-h-9 px-4 text-sm rounded-md');
      break;
    case 'lg':
      classes.push('min-h-10 px-4 text-base rounded-lg');
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

const tagClasses = computed<string>(() => {
  const classes: string[] = [
    'inline-flex items-center gap-1 px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs',
    'max-w-full',
  ];

  return classes.join(' ');
});

const dropdownClasses = computed<string>(() => {
  const classes: string[] = [
    'absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg',
    'max-h-60 overflow-auto',
  ];

  return classes.join(' ');
});

const filteredOptions = computed(() => {
  if (!props.searchable || !searchQuery.value) {
    return props.options;
  }
  return props.options.filter(option =>
    option.label.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const selectedOptions = computed(() => {
  return props.options.filter(option => props.modelValue?.includes(option.value));
});

const displayText = computed(() => {
  const selectedCount = props.modelValue?.length || 0;
  if (selectedCount === 0) {
    return props.placeholder || 'Select options';
  }
  return `${selectedCount} option${selectedCount === 1 ? '' : 's'} selected`;
});

const isSelected = (value: string | number): boolean => {
  return props.modelValue?.includes(value) || false;
};

const canSelectMore = computed(() => {
  if (!props.maxSelections) return true;
  return (props.modelValue?.length || 0) < props.maxSelections;
});

const allFilteredSelected = computed(() => {
  return (
    filteredOptions.value.length > 0 &&
    filteredOptions.value.every(option => isSelected(option.value))
  );
});

const handleSelect = (value: string | number): void => {
  if (props.disabled) return;

  const currentValues = props.modelValue || [];
  let newValues: (string | number)[];

  if (currentValues.includes(value)) {
    newValues = currentValues.filter(v => v !== value);
    emit('deselect', value);
  } else {
    if (!canSelectMore.value) return;
    newValues = [...currentValues, value];
    emit('select', value);
  }

  emit('update:modelValue', newValues);
  emit('change', newValues);
};

const handleRemove = (value: string | number): void => {
  if (props.disabled) return;

  const newValues = (props.modelValue || []).filter(v => v !== value);
  emit('update:modelValue', newValues);
  emit('change', newValues);
  emit('deselect', value);
};

const handleSelectAll = (): void => {
  if (props.disabled) return;

  const availableOptions = filteredOptions.value.filter(option => !option.disabled);

  if (allFilteredSelected.value) {
    const valuesToRemove = availableOptions.map(option => option.value);
    const newValues = (props.modelValue || []).filter(v => !valuesToRemove.includes(v));
    emit('update:modelValue', newValues);
    emit('change', newValues);
  } else {
    const currentValues = props.modelValue || [];
    const valuesToAdd = availableOptions
      .filter(option => !currentValues.includes(option.value))
      .map(option => option.value);

    let newValues = [...currentValues, ...valuesToAdd];

    if (props.maxSelections && newValues.length > props.maxSelections) {
      newValues = newValues.slice(0, props.maxSelections);
    }

    emit('update:modelValue', newValues);
    emit('change', newValues);
  }
};

const toggleDropdown = (): void => {
  if (!props.disabled) {
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
      emit('open');
    } else {
      emit('close');
      searchQuery.value = '';
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
      searchQuery.value = '';
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
          :class="[iconClasses, 'text-gray-400 flex-shrink-0']"
        />

        <div
          v-if="selectedOptions.length > 0"
          class="flex flex-wrap items-center gap-1 flex-1 min-w-0"
        >
          <span v-for="option in selectedOptions" :key="option.value" :class="tagClasses">
            <span class="truncate">{{ option.label }}</span>
            <button
              type="button"
              class="hover:bg-purple-200 rounded-full p-0.5 flex-shrink-0"
              @click.stop="handleRemove(option.value)"
            >
              <x class="w-3 h-3" />
            </button>
          </span>
        </div>

        <span v-else class="text-gray-400 flex-1 text-left truncate">
          {{ displayText }}
        </span>

        <div class="flex items-center gap-2 flex-shrink-0 ml-2">
          <component :is="suffixIcon" v-if="suffixIcon" :class="[iconClasses, 'text-gray-400']" />
          <chevron-down
            :class="[
              iconClasses,
              'text-gray-400 transition-transform duration-200',
              isOpen ? 'transform rotate-180' : '',
            ]"
          />
        </div>
      </button>

      <div v-if="isOpen" :class="dropdownClasses">
        <div v-if="searchable" class="p-2 border-b border-gray-200">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search options..."
            class="w-full px-3 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-purple-500"
            @click.stop
          />
        </div>

        <button
          v-if="showSelectAll && filteredOptions.length > 0"
          type="button"
          class="w-full text-left px-4 py-2 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none transition-colors duration-150 border-b border-gray-200 font-medium text-sm"
          @click="handleSelectAll"
        >
          <div class="flex items-center justify-between">
            <span>{{ allFilteredSelected ? 'Deselect All' : 'Select All' }}</span>
            <check v-if="allFilteredSelected" class="w-4 h-4 text-purple-600" />
          </div>
        </button>

        <button
          v-for="option in filteredOptions"
          :key="option.value"
          type="button"
          :disabled="option.disabled || (!canSelectMore && !isSelected(option.value))"
          :class="[
            'w-full text-left px-4 py-2 hover:bg-gray-100 focus:bg-gray-100',
            'focus:outline-none transition-colors duration-150 flex items-center justify-between',
            option.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
            isSelected(option.value) ? 'bg-purple-50 text-purple-700' : 'text-gray-900',
            !canSelectMore && !isSelected(option.value) ? 'opacity-50 cursor-not-allowed' : '',
          ]"
          @click="handleSelect(option.value)"
        >
          <span class="truncate">{{ option.label }}</span>
          <check
            v-if="isSelected(option.value)"
            class="w-4 h-4 text-purple-600 flex-shrink-0 ml-2"
          />
        </button>

        <div
          v-if="filteredOptions.length === 0"
          class="px-4 py-2 text-sm text-gray-500 text-center"
        >
          {{ searchQuery ? 'No matching options' : 'No options available' }}
        </div>
      </div>
    </div>

    <p v-if="helperText && !errorText" class="mt-1 text-sm text-gray-500">
      {{ helperText }}
    </p>

    <p v-if="errorText" class="mt-1 text-sm text-red-600">
      {{ errorText }}
    </p>

    <p v-if="maxSelections" class="mt-1 text-xs text-gray-500">
      {{ modelValue?.length || 0 }} / {{ maxSelections }} selected
    </p>
  </div>
</template>
