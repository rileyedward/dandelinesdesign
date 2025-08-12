export interface UiTooltipProps {
  content: string;
  placement?: 'top' | 'bottom' | 'left' | 'right';
  disabled?: boolean;
  delay?: number;
  theme?: 'dark' | 'light';
  arrow?: boolean;
}

export interface UiTooltipEmits {
  (event: 'show'): void;
  (event: 'hide'): void;
}
