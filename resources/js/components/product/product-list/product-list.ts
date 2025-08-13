import type { Product } from '@/types/product';

export interface ProductListProps {
    products: Product[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}
