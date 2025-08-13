import type { LucideIcon } from 'lucide-vue-next';
import { Facebook, Instagram, MessageSquareIcon } from 'lucide-vue-next';

export interface NavbarLayoutConfig {
    pageTitle: string;
    leftNavLinks: NavLink[];
    rightNavLinks: NavLink[];
    contactInfo: ContactInfo;
    navigationLinks: NavigationLinkGroup[];
    socialLinks: FooterSocialLink[];
}

export interface NavLink {
    name: string;
    href: string;
}

export interface NavigationLinkGroup {
    title: string;
    links: FooterLink[];
}

export interface FooterLink {
    name: string;
    href: string;
}

export interface FooterSocialLink {
    name: string;
    icon: LucideIcon;
    href: string;
}

export interface ContactInfo {
    email: string;
    phone: string;
    address: string;
}

const config: NavbarLayoutConfig = {
    pageTitle: 'Dandelines Design',
    leftNavLinks: [
        { name: 'Home', href: '/' },
        { name: 'About', href: '/about' },
        { name: 'Services', href: '/services' },
    ],
    rightNavLinks: [
        { name: 'Store', href: '/store' },
        { name: 'Blog', href: '/blog' },
        { name: 'Contact', href: '/contact' },
    ],
    contactInfo: {
        email: 'dandelinesdesign@gmail.com',
        phone: '(816) 509-9824',
        address: 'Independence, MO, USA',
    },
    navigationLinks: [
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
    ],
    socialLinks: [
        { name: 'Instagram', icon: Instagram, href: 'https://www.instagram.com/dandelines_design' },
        { name: 'Facebook', icon: Facebook, href: 'https://www.facebook.com/michele.grotenhuis' },
        { name: 'Threads', icon: MessageSquareIcon, href: 'https://www.threads.com/@michelegrotenhuis' },
    ],
};

export default config;
