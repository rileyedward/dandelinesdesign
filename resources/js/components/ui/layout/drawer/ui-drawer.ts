export interface UiDrawerProps {
  show?: boolean;
  width?: string;
  title?: string;
  description?: string;
  closeable?: boolean;
  closeOnOverlayClick?: boolean;
  closeOnEscape?: boolean;
  persistent?: boolean;
}

export interface UiDrawerEmits {
  (event: 'close'): void;
  (event: 'open'): void;
  (event: 'update:show', show: boolean): void;
}
