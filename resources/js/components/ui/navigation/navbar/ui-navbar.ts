import type { LucideIcon } from 'lucide-vue-next';

export interface NavbarItem {
  label: string;
  route?: string;
  icon?: LucideIcon;
  disabled?: boolean;
}

export interface UiNavbarProps {
  title?: string;
  items?: NavbarItem[];
  showMobileMenuButton?: boolean;
  showLogo?: boolean;
  logoSrc?: string;
  fixed?: boolean;
  transparent?: boolean;
  activeRoute?: string;
}

export interface UiNavbarEmits {
  (event: 'navigate', item: NavbarItem): void;
  (event: 'update:activeRoute', value: string): void;
  (event: 'toggle-sidebar'): void;
}
