import { ContactInfo, FooterSocialLink, NavigationLinkGroup } from '@/types/components/footer';
import { Facebook, Instagram, MessageSquareIcon } from 'lucide-vue-next';

export const navigationLinks: NavigationLinkGroup[] = [
    {
        title: 'Main',
        links: [
            { name: 'Home', href: '/' },
            { name: 'About', href: '/about' },
            { name: 'Services', href: '/services' },
        ],
    },
    {
        title: 'Shop & Blog',
        links: [
            { name: 'Store', href: '/store' },
            { name: 'Blog', href: '/blog' },
        ],
    },
    {
        title: 'Support',
        links: [{ name: 'Contact', href: '/contact' }],
    },
];

export const socialLinks: FooterSocialLink[] = [
    { name: 'Instagram', icon: Instagram, href: 'https://instagram.com/dandelinesdesign' },
    { name: 'Facebook', icon: Facebook, href: 'https://facebook.com/dandelinesdesign' },
    { name: 'Threads', icon: MessageSquareIcon, href: 'https://threads.net/dandelinesdesign' },
];

export const contactInfo: ContactInfo = {
    email: 'dandelines@gmail.com',
    phone: '(816) 509-9824',
    address: 'Kansas City, MO, USA',
};
