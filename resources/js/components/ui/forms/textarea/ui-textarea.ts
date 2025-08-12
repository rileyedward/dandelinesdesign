export interface UiTextareaProps {
  modelValue?: string;
  placeholder?: string;
  label?: string;
  helperText?: string;
  errorText?: string;
  size?: 'sm' | 'md' | 'lg';
  variant?: 'default' | 'outlined' | 'filled';
  disabled?: boolean;
  readonly?: boolean;
  required?: boolean;
  fullWidth?: boolean;
  rows?: number;
  cols?: number;
  maxLength?: number;
  minLength?: number;
  resize?: 'none' | 'both' | 'horizontal' | 'vertical';
  autocomplete?: string;
}

export interface UiTextareaEmits {
  (event: 'update:modelValue', value: string): void;
  (event: 'input', e: Event): void;
  (event: 'change', e: Event): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
  (event: 'keyup', e: KeyboardEvent): void;
  (event: 'keydown', e: KeyboardEvent): void;
}
