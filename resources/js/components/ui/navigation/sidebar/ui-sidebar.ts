import type { LucideIcon } from 'lucide-vue-next';
import type { DropdownMenuItem } from '@/components/ui/data/dropdown-menu/ui-dropdown-menu';

export interface SidebarItem {
  label: string;
  route?: string;
  icon?: LucideIcon;
  disabled?: boolean;
  children?: SidebarItem[];
}

export interface UiSidebarProps {
  items: SidebarItem[];
  title?: string;
  collapsible?: boolean;
  defaultOpen?: boolean;
  activeRoute?: string;
  width?: string;
  profileMenu?: {
    userName: string;
    menuItems: DropdownMenuItem[];
  };
}

export interface UiSidebarEmits {
  (event: 'navigate', item: SidebarItem): void;
  (event: 'update:activeRoute', value: string): void;
  (event: 'profile-action', item: DropdownMenuItem): void;
}
