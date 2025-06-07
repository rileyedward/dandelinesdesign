import { Product } from '@/types/models/product';

export interface ProductBannerProps {
    product: Product;
}

export interface ProductBannerEmits {
    (e: 'edit', product: Product): void;
    (e: 'delete', id: number): void;
}
