import type { LucideIcon } from 'lucide-vue-next';

export interface UiInputProps {
  type?: 'text' | 'email' | 'password' | 'number' | 'tel' | 'url' | 'search';
  modelValue?: string | number;
  placeholder?: string;
  label?: string;
  helperText?: string;
  errorText?: string;
  size?: 'sm' | 'md' | 'lg';
  variant?: 'default' | 'outlined' | 'filled';
  prefixIcon?: LucideIcon;
  suffixIcon?: LucideIcon;
  disabled?: boolean;
  readonly?: boolean;
  required?: boolean;
  fullWidth?: boolean;
  maxLength?: number;
  minLength?: number;
  min?: number;
  max?: number;
  step?: number;
  autocomplete?: string;
}

export interface UiInputEmits {
  (event: 'update:modelValue', value: string | number): void;
  (event: 'input', e: Event): void;
  (event: 'change', e: Event): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
  (event: 'keyup', e: KeyboardEvent): void;
  (event: 'keydown', e: KeyboardEvent): void;
  (event: 'enter', e: KeyboardEvent): void;
}
