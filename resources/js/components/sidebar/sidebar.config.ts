import { SidebarLink } from '@/types/components/sidebar';
import { LayoutIcon, FileTextIcon, MessageSquareIcon, ShoppingBagIcon, QuoteIcon, StarIcon } from 'lucide-vue-next';

export const sidebarLinks: SidebarLink[] = [
    {
        name: 'Dashboard',
        href: '/admin',
        icon: LayoutIcon,
    },
    {
        name: 'Blog Posts',
        href: '/admin/blog-posts',
        icon: FileTextIcon,
    },
    {
        name: 'Contact Messages',
        href: '/admin/contact-messages',
        icon: MessageSquareIcon,
    },
    {
        name: 'Products',
        href: '/admin/products',
        icon: ShoppingBagIcon,
    },
    {
        name: 'Quotes',
        href: '/admin/quotes',
        icon: QuoteIcon,
    },
    {
        name: 'Testimonials',
        href: '/admin/testimonials',
        icon: StarIcon,
    },
];
