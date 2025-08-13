import type { Category } from '@/types/category';

export interface CategoryListProps {
    categories: Category[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}
