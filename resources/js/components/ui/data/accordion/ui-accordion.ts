import type { LucideIcon } from 'lucide-vue-next';

export interface AccordionItem {
  title: string;
  content: string;
  icon?: LucideIcon;
  disabled?: boolean;
  defaultOpen?: boolean;
}

export interface UiAccordionProps {
  items: AccordionItem[];
  multiple?: boolean;
  bordered?: boolean;
  disabled?: boolean;
  variant?: 'default' | 'filled';
}

export interface UiAccordionEmits {
  (event: 'toggle', item: AccordionItem, isOpen: boolean): void;
}
