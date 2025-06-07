import { Product } from '@/types/models/product';

export interface ProductAdminPageProps {
    products: Product[];
}

export interface ProductAdminEditPageProps {
    product: Product;
}
