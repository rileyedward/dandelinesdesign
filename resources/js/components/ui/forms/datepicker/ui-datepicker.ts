import type { LucideIcon } from 'lucide-vue-next';

export interface UiDatePickerProps {
  modelValue?: Date | string | null;
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
  minDate?: Date | string;
  maxDate?: Date | string;
  format?: string;
  showWeekNumbers?: boolean;
  firstDayOfWeek?: 0 | 1 | 2 | 3 | 4 | 5 | 6;
  disabledDates?: Date[] | string[];
  enabledDates?: Date[] | string[];
  readonly?: boolean;
}

export interface UiDatePickerEmits {
  (event: 'update:modelValue', value: Date | null): void;
  (event: 'change', value: Date | null): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
  (event: 'open'): void;
  (event: 'close'): void;
}
