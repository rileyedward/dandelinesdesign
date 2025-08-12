import type { LucideIcon } from 'lucide-vue-next';
import { Search, User } from 'lucide-vue-next';

export interface NavbarLayoutConfig {
    title: string;
    navbarRightItems: NavbarRightItem[];
}

export interface NavbarRightItem {
    icon: LucideIcon;
    ariaLabel: string;
    onClick?: () => void;
}

const config: NavbarLayoutConfig = {
    title: 'Component Library',
    navbarRightItems: [
        {
            icon: Search,
            ariaLabel: 'Search',
        },
        {
            icon: User,
            ariaLabel: 'User profile',
        },
    ],
};

export default config;
