import { SidebarLink } from '@/types/components/sidebar';
import { LayoutIcon, FileTextIcon, MessageSquareIcon, ShoppingBagIcon, QuoteIcon, StarIcon } from 'lucide-vue-next';

export const sidebarLinks: SidebarLink[] = [
    {
        name: 'Dashboard',
        href: route('admin.index'),
        icon: LayoutIcon,
    },
    {
        name: 'Messages',
        href: route('admin.contact.index'),
        icon: MessageSquareIcon,
    },
    {
        name: 'Quotes',
        href: route('admin.quotes.index'),
        icon: QuoteIcon,
    },
    {
        name: 'Products',
        href: route('admin.products.index'),
        icon: ShoppingBagIcon,
    },
    {
        name: 'Blog Posts',
        href: route('admin.blog.index'),
        icon: FileTextIcon,
    },
    {
        name: 'Testimonials',
        href: route('admin.testimonials.index'),
        icon: StarIcon,
    },
];
