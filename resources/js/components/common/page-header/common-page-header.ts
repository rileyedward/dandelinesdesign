import type { Component } from 'vue';

export interface CommonPageHeaderProps {
    title: string;
    subtitle?: string;
    icon?: Component;
    variant?: 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info';
}
