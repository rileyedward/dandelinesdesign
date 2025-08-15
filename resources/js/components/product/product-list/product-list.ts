import type { Product } from '@/types/product';

export interface ProductListProps {
    products: Product[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}

export interface ProductListEmits {
    view: [product: Product];
    edit: [product: Product];
    create: [];
}
