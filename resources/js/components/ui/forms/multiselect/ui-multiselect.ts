import type { LucideIcon } from 'lucide-vue-next';

export interface MultiSelectOption {
  value: string | number;
  label: string;
  disabled?: boolean;
}

export interface UiMultiSelectProps {
  modelValue?: (string | number)[];
  options: MultiSelectOption[];
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
  searchable?: boolean;
  maxSelections?: number;
  showSelectAll?: boolean;
}

export interface UiMultiSelectEmits {
  (event: 'update:modelValue', value: (string | number)[]): void;
  (event: 'change', value: (string | number)[]): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
  (event: 'open'): void;
  (event: 'close'): void;
  (event: 'select', value: string | number): void;
  (event: 'deselect', value: string | number): void;
}
