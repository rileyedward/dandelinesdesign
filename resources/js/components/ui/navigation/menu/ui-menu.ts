import type { LucideIcon } from 'lucide-vue-next';

export interface MenuItem {
  label: string;
  value: string;
  href?: string;
  icon?: LucideIcon;
  disabled?: boolean;
  children?: MenuItem[];
}

export interface UiMenuProps {
  items: MenuItem[];
  title?: string;
  collapsible?: boolean;
  defaultOpen?: boolean;
  variant?: 'vertical' | 'horizontal';
  activeItem?: string;
}

export interface UiMenuEmits {
  (event: 'select', item: MenuItem): void;
  (event: 'update:activeItem', value: string): void;
}
