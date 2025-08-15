<script setup lang="ts">
import { computed } from 'vue';
import type { StoreTabsEmits as Emits, StoreTabsProps as Props, StoreTabItem } from './store-tabs';

const props = withDefaults(defineProps<Props>(), {
    modelValue: '',
    disabled: false,
});

const emit = defineEmits<Emits>();

const activeTab = computed(() => {
    return props.items.find((item) => item.value === props.modelValue);
});

const selectTab = (item: StoreTabItem): void => {
    if (!props.disabled && !item.disabled) {
        emit('update:modelValue', item.value);
        emit('change', item);
    }
};

const getTabClasses = (item: StoreTabItem) => {
    const isActive = item.value === props.modelValue;
    const isDisabled = props.disabled || item.disabled;

    return [
        'relative flex items-center px-6 py-3 text-sm font-medium transition-all duration-200 rounded-lg',
        isDisabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
        isActive
            ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25 transform scale-105'
            : 'text-gray-700 hover:text-gray-900 hover:bg-white hover:shadow-md',
    ];
};
</script>

<template>
    <div class="flex flex-wrap gap-3 rounded-xl bg-gray-50 p-2">
        <button v-for="item in items" :key="item.value" :class="getTabClasses(item)" :disabled="disabled || item.disabled" @click="selectTab(item)">
            <component v-if="item.icon" :is="item.icon" class="mr-2 h-4 w-4" />

            <span>{{ item.label }}</span>

            <span
                v-if="item.count !== undefined"
                :class="[
                    'ml-2 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full px-1.5 text-xs font-medium',
                    item.value === modelValue ? 'bg-white/25 text-white' : 'bg-gray-200 text-gray-600',
                ]"
            >
                {{ item.count }}
            </span>
        </button>
    </div>
</template>
