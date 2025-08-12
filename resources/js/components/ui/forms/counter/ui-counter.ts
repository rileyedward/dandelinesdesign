export interface UiCounterProps {
  modelValue: number;
  min?: number;
  max?: number;
  step?: number;
  disabled?: boolean;
  label?: string;
  size?: 'sm' | 'md' | 'lg' | 'xl';
}

export interface UiCounterEmits {
  (event: 'update:modelValue', value: number): void;
  (event: 'change', value: number): void;
  (event: 'increment'): void;
  (event: 'decrement'): void;
}
