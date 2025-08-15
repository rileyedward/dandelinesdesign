import type { Component } from 'vue';

export interface StoreTabItem {
    label: string;
    value: string;
    icon?: Component;
    disabled?: boolean;
    count?: number;
}

export interface StoreTabsProps {
    items: StoreTabItem[];
    modelValue: string;
    disabled?: boolean;
}

export interface StoreTabsEmits {
    'update:modelValue': [value: string];
    change: [item: StoreTabItem];
}
