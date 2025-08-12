export interface UiCheckboxProps {
  modelValue?: boolean;
  label?: string;
  description?: string;
  errorText?: string;
  size?: 'sm' | 'md' | 'lg';
  variant?: 'default' | 'outlined';
  disabled?: boolean;
  required?: boolean;
  indeterminate?: boolean;
  value?: string | number;
}

export interface UiCheckboxEmits {
  (event: 'update:modelValue', value: boolean): void;
  (event: 'change', value: boolean, originalEvent: Event): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
}
