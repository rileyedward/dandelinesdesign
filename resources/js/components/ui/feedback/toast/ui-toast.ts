import type { Component } from 'vue';

export interface UiToastProps {
  variant?: 'info' | 'success' | 'warning' | 'error';
  position?:
    | 'top-right'
    | 'top-left'
    | 'bottom-right'
    | 'bottom-left'
    | 'top-center'
    | 'bottom-center';
  duration?: number;
  title?: string;
  description?: string;
  dismissible?: boolean;
  icon?: Component;
  show?: boolean;
  persistent?: boolean;
}

export interface UiToastEmits {
  (event: 'close'): void;
  (event: 'dismiss'): void;
}
