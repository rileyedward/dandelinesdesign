export interface UiRangeProps {
  modelValue: [number, number];
  min?: number;
  max?: number;
  step?: number;
  disabled?: boolean;
  showValues?: boolean;
  label?: string;
  tooltip?: boolean;
}

export interface UiRangeEmits {
  (event: 'update:modelValue', value: [number, number]): void;
  (event: 'change', value: [number, number]): void;
  (event: 'input', value: [number, number]): void;
}
