import type { LucideIcon } from 'lucide-vue-next';

export interface DropdownMenuItem {
  id: string;
  label: string;
  icon?: LucideIcon;
  disabled?: boolean;
  separator?: boolean;
  variant?: 'default' | 'danger';
  href?: string;
  action?: () => void;
}

export interface UiDropdownMenuProps {
  items: DropdownMenuItem[];
  placement?: 'top' | 'bottom' | 'left' | 'right';
  disabled?: boolean;
  closeOnSelect?: boolean;
  maxHeight?: string;
}

export interface UiDropdownMenuEmits {
  (event: 'select', item: DropdownMenuItem): void;
  (event: 'open'): void;
  (event: 'close'): void;
}
