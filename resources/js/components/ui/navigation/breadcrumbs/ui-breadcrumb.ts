import type { LucideIcon } from 'lucide-vue-next';

export interface BreadcrumbItem {
  label: string;
  href?: string;
  icon?: LucideIcon;
}

export interface UiBreadcrumbProps {
  items: BreadcrumbItem[];
  separator?: string;
  homeIcon?: LucideIcon;
  showHomeIcon?: boolean;
}

export interface UiBreadcrumbEmits {
  (event: 'navigate', item: BreadcrumbItem): void;
}
