import type { LucideIcon } from 'lucide-vue-next';

export interface SelectOption {
  value: string | number;
  label: string;
  disabled?: boolean;
}

export interface UiSelectProps {
  modelValue?: string | number;
  options: SelectOption[];
  placeholder?: string;
  label?: string;
  helperText?: string;
  errorText?: string;
  size?: 'sm' | 'md' | 'lg';
  variant?: 'default' | 'outlined' | 'filled';
  prefixIcon?: LucideIcon;
  suffixIcon?: LucideIcon;
  disabled?: boolean;
  required?: boolean;
  fullWidth?: boolean;
  multiple?: boolean;
  searchable?: boolean;
}

export interface UiSelectEmits {
  (event: 'update:modelValue', value: string | number | (string | number)[]): void;
  (event: 'change', value: string | number | (string | number)[]): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
  (event: 'open'): void;
  (event: 'close'): void;
}
