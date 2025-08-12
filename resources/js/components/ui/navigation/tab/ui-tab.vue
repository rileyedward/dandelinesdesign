<script setup lang="ts">
import { computed } from 'vue';
import type { UiTabProps as Props, UiTabEmits as Emits, TabItem } from './ui-tab';

const props = withDefaults(defineProps<Props>(), {
  modelValue: '',
  disabled: false,
  variant: 'default',
  fullWidth: false,
});

const emit = defineEmits<Emits>();

const activeTab = computed(() => {
  return props.items.find(item => item.value === props.modelValue);
});

const selectTab = (item: TabItem): void => {
  if (!props.disabled && !item.disabled) {
    emit('update:modelValue', item.value);
    emit('change', item);
  }
};

const getTabClasses = (item: TabItem) => {
  const isActive = item.value === props.modelValue;
  const isDisabled = props.disabled || item.disabled;

  const baseClasses = [
    'flex items-center px-4 py-2 text-sm font-medium transition-colors',
    isDisabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
    props.fullWidth ? 'flex-1 justify-center' : '',
  ];

  if (props.variant === 'default') {
    return [
      ...baseClasses,
      'rounded-md',
      isActive
        ? 'bg-purple-100 text-purple-700'
        : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100',
    ];
  } else if (props.variant === 'pills') {
    return [
      ...baseClasses,
      'rounded-full',
      isActive ? 'bg-purple-500 text-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100',
    ];
  } else if (props.variant === 'underline') {
    return [
      ...baseClasses,
      'border-b-2',
      isActive
        ? 'border-purple-500 text-purple-700'
        : 'border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300',
    ];
  }

  return baseClasses;
};
</script>

<template>
  <div
    class="flex"
    :class="[
      fullWidth ? 'w-full' : '',
      variant === 'underline' ? 'border-b border-gray-200' : 'space-x-1',
    ]"
  >
    <button
      v-for="(item, index) in items"
      :key="index"
      type="button"
      :class="getTabClasses(item)"
      :disabled="disabled || item.disabled"
      @click="selectTab(item)"
    >
      <component :is="item.icon" v-if="item.icon" class="w-4 h-4 mr-2" />
      {{ item.label }}
    </button>
  </div>

  <div class="mt-4">
    <slot :active-tab="activeTab"></slot>
  </div>
</template>
