import type { Component } from 'vue';

export interface UiAlertProps {
  variant?: 'info' | 'success' | 'warning' | 'error';
  size?: 'sm' | 'md' | 'lg';
  title?: string;
  description?: string;
  dismissible?: boolean;
  icon?: Component;
  show?: boolean;
}

export interface UiAlertEmits {
  (event: 'close'): void;
  (event: 'dismiss'): void;
}
