<script setup lang="ts">
import { ref, computed } from 'vue';
import { ChevronDown, ChevronUp } from 'lucide-vue-next';
import type {
  UiDropdownProps as Props,
  UiDropdownEmits as Emits,
  DropdownItem,
} from './ui-dropdown';

const props = withDefaults(defineProps<Props>(), {
  modelValue: '',
  placeholder: 'Select an option',
  disabled: false,
});

const emit = defineEmits<Emits>();

const isOpen = ref(false);
const selectedItem = computed(() => {
  return props.items.find(item => item.value === props.modelValue);
});

const toggleDropdown = (): void => {
  if (!props.disabled) {
    isOpen.value = !isOpen.value;
  }
};

const selectItem = (item: DropdownItem): void => {
  if (!item.disabled) {
    emit('update:modelValue', item.value);
    emit('select', item);
    isOpen.value = false;
  }
};

const closeDropdown = (): void => {
  isOpen.value = false;
};
</script>

<template>
  <div class="relative w-full">
    <button
      type="button"
      class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 disabled:opacity-50 disabled:cursor-not-allowed"
      :disabled="disabled"
      @click="toggleDropdown"
      @blur="closeDropdown"
    >
      <div class="flex items-center">
        <component :is="icon" v-if="icon" class="w-4 h-4 mr-2" />
        <span v-if="selectedItem">{{ selectedItem.label }}</span>
        <span v-else class="text-gray-400">{{ placeholder }}</span>
      </div>
      <component :is="isOpen ? ChevronUp : ChevronDown" class="w-4 h-4 ml-2" />
    </button>

    <div
      v-if="isOpen"
      class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg"
    >
      <ul class="py-1 overflow-auto max-h-60">
        <li
          v-for="(item, index) in items"
          :key="index"
          :class="[
            'px-4 py-2 text-sm cursor-pointer flex items-center',
            item.disabled
              ? 'text-gray-400 cursor-not-allowed'
              : 'text-gray-700 hover:bg-purple-100',
            item.value === modelValue ? 'bg-purple-50 text-purple-700' : '',
          ]"
          @click="selectItem(item)"
        >
          <component :is="item.icon" v-if="item.icon" class="w-4 h-4 mr-2" />
          {{ item.label }}
        </li>
      </ul>
    </div>
  </div>
</template>
