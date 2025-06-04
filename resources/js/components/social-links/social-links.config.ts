import { SocialLink } from '@/types/components/social-links';
import { FacebookIcon, InstagramIcon, MailIcon, MessageCircleIcon } from 'lucide-vue-next';

export const socialLinks: SocialLink[] = [
    {
        name: 'Instagram',
        url: 'https://instagram.com/#',
        icon: InstagramIcon,
    },
    {
        name: 'Facebook',
        url: 'https://facebook.com/#',
        icon: FacebookIcon,
    },
    {
        name: 'Threads',
        url: 'https://threads.net/#',
        icon: MessageCircleIcon,
    },
    {
        name: 'Email',
        url: 'mailto:contact@dandelinesdesign.com',
        icon: MailIcon,
    },
];
