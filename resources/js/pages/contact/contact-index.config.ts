import type { LucideIcon } from 'lucide-vue-next';
import { FacebookIcon, InstagramIcon, MailIcon, MessageCircleIcon } from 'lucide-vue-next';

interface SocialLink {
    name: string;
    url: string;
    icon: LucideIcon;
}

export const socialLinks: SocialLink[] = [
    {
        name: 'Instagram',
        url: 'https://www.instagram.com/dandelines_design',
        icon: InstagramIcon,
    },
    {
        name: 'Facebook',
        url: 'https://www.facebook.com/michele.grotenhuis',
        icon: FacebookIcon,
    },
    {
        name: 'Threads',
        url: 'https://www.threads.com/@michelegrotenhuis',
        icon: MessageCircleIcon,
    },
    {
        name: 'Email',
        url: 'mailto:dandelines@gmail.com',
        icon: MailIcon,
    },
];
