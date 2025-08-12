export interface UiSliderProps {
  modelValue: number;
  min?: number;
  max?: number;
  step?: number;
  disabled?: boolean;
  showValue?: boolean;
  label?: string;
  tooltip?: boolean;
}

export interface UiSliderEmits {
  (event: 'update:modelValue', value: number): void;
  (event: 'change', value: number): void;
  (event: 'input', value: number): void;
}
