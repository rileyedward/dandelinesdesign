import {
  Home,
  Layout,
  Circle,
  Type,
  CheckSquare,
  Calendar,
  Bell,
  AlertTriangle,
  MessageSquare,
  CreditCard,
  BarChart3,
  ChevronDown,
  Table,
  LogOut,
  Settings,
} from 'lucide-vue-next';
import type { SidebarItem } from '@/components/ui/navigation/sidebar/ui-sidebar';
import type { DropdownMenuItem } from '@/components/ui/data/dropdown-menu/ui-dropdown-menu';

export interface SidebarLayoutConfig {
  title: string;
  sidebarItems: SidebarItem[];
  profileMenu: {
    userName: string;
    menuItems: DropdownMenuItem[];
  };
}

const config: SidebarLayoutConfig = {
  title: 'Component Library',
  sidebarItems: [
    { label: 'Home', route: '/', icon: Home },
    {
      label: 'Forms',
      icon: CheckSquare,
      children: [
        { label: 'Button', route: '/button', icon: Circle },
        { label: 'Input', route: '/input', icon: Type },
        { label: 'Textarea', route: '/textarea', icon: Type },
        { label: 'Select', route: '/select', icon: CheckSquare },
        { label: 'Checkbox', route: '/checkbox', icon: CheckSquare },
        { label: 'Radio', route: '/radio', icon: CheckSquare },
        { label: 'MultiSelect', route: '/multiselect', icon: CheckSquare },
        { label: 'DatePicker', route: '/datepicker', icon: Calendar },
        { label: 'Slider', route: '/slider', icon: Circle },
        { label: 'Range', route: '/range', icon: Circle },
        { label: 'Counter', route: '/counter', icon: Circle },
        { label: 'File Upload', route: '/file-upload', icon: Circle },
        { label: 'Switch', route: '/switch', icon: Circle },
      ],
    },
    {
      label: 'Navigation',
      icon: Layout,
      children: [
        { label: 'Breadcrumb', route: '/breadcrumb', icon: Layout },
        { label: 'Dropdown', route: '/dropdown', icon: Layout },
        { label: 'Dropdown Menu', route: '/dropdown-menu', icon: ChevronDown },
        { label: 'Menu', route: '/menu', icon: Layout },
        { label: 'Tab', route: '/tab', icon: Layout },
      ],
    },
    {
      label: 'Feedback',
      icon: Bell,
      children: [
        { label: 'Alert', route: '/alert', icon: AlertTriangle },
        { label: 'Toast', route: '/toast', icon: Bell },
        { label: 'Modal', route: '/modal', icon: MessageSquare },
      ],
    },
    {
      label: 'Layout',
      icon: Layout,
      children: [
        { label: 'Card', route: '/card', icon: CreditCard },
        { label: 'Container', route: '/container', icon: Layout },
        { label: 'Drawer', route: '/drawer', icon: Layout },
      ],
    },
    {
      label: 'Data',
      icon: BarChart3,
      children: [
        { label: 'Accordion', route: '/accordion', icon: BarChart3 },
        { label: 'Chart', route: '/chart', icon: BarChart3 },
        { label: 'Table', route: '/table', icon: Table },
        { label: 'Tooltip', route: '/tooltip', icon: MessageSquare },
      ],
    },
  ],
  profileMenu: {
    userName: 'John Doe',
    menuItems: [
      {
        id: 'settings',
        label: 'Settings',
        icon: Settings,
        disabled: false,
        href: '/settings',
      },
      {
        id: 'divider',
        label: '',
        separator: true,
      },
      {
        id: 'logout',
        label: 'Log Out',
        icon: LogOut,
        variant: 'danger' as const,
        disabled: false,
        action: () => {
          // TODO...
        },
      },
    ],
  },
};

export default config;
