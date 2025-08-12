import type { DropdownMenuItem } from '@/components/ui/data/dropdown-menu/ui-dropdown-menu';
import type { SidebarItem } from '@/components/ui/navigation/sidebar/ui-sidebar';
import { router } from '@inertiajs/vue3';
import { FileText, Home, LogOut, Mail, MessageSquare, Package, Settings, ShoppingBag, Star, Tag, UserCheck, Users } from 'lucide-vue-next';

export interface SidebarLayoutConfig {
    title: string;
    sidebarItems: SidebarItem[];
    profileMenu: {
        userName: string;
        menuItems: DropdownMenuItem[];
    };
}

const config: SidebarLayoutConfig = {
    title: 'Dandeline Designs',
    sidebarItems: [
        { label: 'Dashboard', route: '/admin/dashboard', icon: Home },
        {
            label: 'Content Management',
            icon: FileText,
            children: [
                { label: 'Blog Posts', route: '/admin/blog', icon: FileText },
                { label: 'Contact Messages', route: '/admin/messages', icon: Mail },
            ],
        },
        {
            label: 'Customer Relations',
            icon: Users,
            children: [
                { label: 'Quote Requests', route: '/admin/quotes', icon: MessageSquare },
                { label: 'Testimonials', route: '/admin/testimonials', icon: Star },
                { label: 'Leads', route: '/admin/leads', icon: UserCheck },
            ],
        },
        {
            label: 'Ecommerce',
            icon: ShoppingBag,
            children: [
                { label: 'Categories', route: '/admin/categories', icon: Tag },
                { label: 'Products', route: '/admin/products', icon: Package },
            ],
        },
    ],
    profileMenu: {
        userName: 'Admin User',
        menuItems: [
            {
                id: 'settings',
                label: 'Settings',
                icon: Settings,
                disabled: false,
                href: '/admin/settings',
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
                    router.delete(route('auth.login.destroy'));
                },
            },
        ],
    },
};

export default config;
