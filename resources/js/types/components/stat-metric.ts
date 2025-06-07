import { LucideIcon } from 'lucide-vue-next';

export interface StatMetricProps {
    color: 'blue' | 'green' | 'purple' | 'yellow' | 'pink' | 'red' | 'indigo' | 'gray';
    icon: LucideIcon;
    title: string;
    subtitle: string;
    href?: string;
}
