import { Product } from '@/types/models/product';

export interface ProductCardProps {
    product: Product;
}

export interface ProductCardEmits {
    (e: 'click', product: Product): void;
}
