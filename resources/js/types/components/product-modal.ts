import { Product } from '@/types/models/product';

export interface ProductModalProps {
    product: Product;
    isOpen: boolean;
    onClose: () => void;
}
