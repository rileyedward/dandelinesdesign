export interface UiRadioProps {
  modelValue?: string | number | boolean;
  value: string | number | boolean;
  name?: string;
  label?: string;
  description?: string;
  errorText?: string;
  size?: 'sm' | 'md' | 'lg';
  variant?: 'default' | 'outlined';
  disabled?: boolean;
  required?: boolean;
}

export interface UiRadioEmits {
  (event: 'update:modelValue', value: string | number | boolean): void;
  (event: 'change', value: string | number | boolean, originalEvent: Event): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
}
