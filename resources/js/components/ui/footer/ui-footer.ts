import type { LucideIcon } from 'lucide-vue-next';

export interface FooterLink {
    name: string;
    href: string;
}

export interface NavigationLinkGroup {
    title: string;
    links: FooterLink[];
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

export interface UiFooterProps {
    contactInfo: ContactInfo;
    navigationLinks: NavigationLinkGroup[];
    socialLinks: FooterSocialLink[];
}

export interface UiFooterEmits {
    (event: 'admin-login-click'): void;
}