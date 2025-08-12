import type { LucideIcon } from 'lucide-vue-next';

export interface UiSwitchProps {
  modelValue: boolean;
  disabled?: boolean;
  label?: string;
  size?: 'sm' | 'md' | 'lg';
  color?: 'primary' | 'success' | 'danger' | 'warning' | 'info';
  leftText?: string;
  rightText?: string;
  leftIcon?: LucideIcon;
  rightIcon?: LucideIcon;
  name?: string;
  required?: boolean;
  helperText?: string;
  error?: string;
}

export interface UiSwitchEmits {
  (event: 'update:modelValue', value: boolean): void;
  (event: 'change', value: boolean): void;
}
