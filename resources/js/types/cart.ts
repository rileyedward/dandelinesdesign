import type { Price, Product } from './product';

export interface CartItem {
    id: string;
    product: Product;
    price: Price;
    quantity: number;
    addedAt: Date;
}

export interface Cart {
    items: CartItem[];
    isOpen: boolean;
    totalItems: number;
    totalPrice: number;
}
