import { ContactInfo, FooterSocialLink, NavigationLinkGroup } from '@/types/components/footer';
import { Facebook, Instagram, Twitter } from 'lucide-vue-next';

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
    { name: 'Facebook', icon: Facebook, href: 'https://facebook.com/dandelinesdesign' },
    { name: 'Instagram', icon: Instagram, href: 'https://instagram.com/dandelinesdesign' },
    { name: 'Twitter', icon: Twitter, href: 'https://twitter.com/dandelinesdesign' },
];

export const contactInfo: ContactInfo = {
    email: 'hello@dandelinesdesign.com',
    phone: '(555) 123-4567',
    address: '123 Design Street, Creative City, CD 12345',
};
