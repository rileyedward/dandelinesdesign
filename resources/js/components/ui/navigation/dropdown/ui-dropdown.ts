import type { LucideIcon } from 'lucide-vue-next';

export interface DropdownItem {
  label: string;
  value: string;
  icon?: LucideIcon;
  disabled?: boolean;
}

export interface UiDropdownProps {
  items: DropdownItem[];
  modelValue?: string;
  label?: string;
  placeholder?: string;
  disabled?: boolean;
  icon?: LucideIcon;
}

export interface UiDropdownEmits {
  (event: 'update:modelValue', value: string): void;
  (event: 'select', item: DropdownItem): void;
}
