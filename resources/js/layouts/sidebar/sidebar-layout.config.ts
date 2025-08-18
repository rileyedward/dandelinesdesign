import type { DropdownMenuItem } from '@/components/ui/data/dropdown-menu/ui-dropdown-menu';
import type { SidebarItem } from '@/components/ui/navigation/sidebar/ui-sidebar';
import { router } from '@inertiajs/vue3';
import { Bell, FileText, Home, LogOut, Mail, MessageSquare, Newspaper, Package, ShoppingBag, Star, Tag, UserCheck, Users } from 'lucide-vue-next';

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
        { label: 'Dashboard', route: '/admin', icon: Home },
        {
            label: 'Customer Relations',
            icon: Users,
            children: [
                { label: 'Messages', route: '/admin/messages', icon: Mail },
                { label: 'Quotes', route: '/admin/quotes', icon: MessageSquare },
                { label: 'Leads', route: '/admin/leads', icon: UserCheck },
            ],
        },
        {
            label: 'Ecommerce',
            icon: ShoppingBag,
            children: [
                { label: 'Orders', route: '/admin/orders', icon: ShoppingBag },
                { label: 'Products', route: '/admin/products', icon: Package },
                { label: 'Categories', route: '/admin/categories', icon: Tag },
            ],
        },
        {
            label: 'Newsletter',
            icon: Newspaper,
            children: [
                { label: 'Subscribers', route: '/admin/newsletter/subscribers', icon: Users },
                { label: 'Templates', route: '/admin/newsletter/templates', icon: Mail },
            ],
        },
        {
            label: 'Content Management',
            icon: FileText,
            children: [
                { label: 'Blog Posts', route: '/admin/blog', icon: FileText },
                { label: 'Testimonials', route: '/admin/testimonials', icon: Star },
            ],
        },
        { label: 'Notifications', route: '#notifications', icon: Bell },
    ],
    profileMenu: {
        userName: 'Admin User',
        menuItems: [
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
