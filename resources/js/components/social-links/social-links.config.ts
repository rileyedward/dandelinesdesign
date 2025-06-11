import { SocialLink } from '@/types/components/social-links';
import { FacebookIcon, InstagramIcon, MailIcon, MessageCircleIcon } from 'lucide-vue-next';

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
