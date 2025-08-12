import type { LucideIcon } from 'lucide-vue-next';

export interface TabItem {
  label: string;
  value: string;
  icon?: LucideIcon;
  disabled?: boolean;
}

export interface UiTabProps {
  items: TabItem[];
  modelValue?: string;
  disabled?: boolean;
  variant?: 'default' | 'pills' | 'underline';
  fullWidth?: boolean;
}

export interface UiTabEmits {
  (event: 'update:modelValue', value: string): void;
  (event: 'change', item: TabItem): void;
}
