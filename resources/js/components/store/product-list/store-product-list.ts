import type { Product } from '@/types/product';

export interface StoreProductListProps {
    products: Product[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}

export interface StoreProductListEmits {
    view: [product: Product];
}
