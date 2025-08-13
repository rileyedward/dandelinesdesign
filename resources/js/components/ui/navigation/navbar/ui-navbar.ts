export interface NavLink {
    name: string;
    href: string;
}

export interface UiNavbarProps {
    leftNavLinks?: NavLink[];
    rightNavLinks?: NavLink[];
}

export interface UiNavbarEmits {
    (event: 'mobile-menu-toggle'): void;
}
