import type { LucideIcon } from 'lucide-vue-next';

export interface UiButtonProps {
  type?: 'button' | 'submit' | 'reset';
  label?: string;
  variant?: 'primary' | 'secondary' | 'outline' | 'success' | 'danger' | 'warning' | 'info';
  size?: 'sm' | 'md' | 'lg' | 'xl';
  fullWidth?: boolean;
  prefixIcon?: LucideIcon;
  suffixIcon?: LucideIcon;
  disabled?: boolean;
  loading?: boolean;
}

export interface UiButtonEmits {
  (event: 'click', e: MouseEvent): void;
  (event: 'focus', e: FocusEvent): void;
  (event: 'blur', e: FocusEvent): void;
  (event: 'keyup', e: KeyboardEvent): void;
  (event: 'keydown', e: KeyboardEvent): void;
}
