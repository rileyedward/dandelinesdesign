export interface Product {
    id: number;
    name: string;
    description: string;
    image_url: string | null;
    price: number;
    is_available: boolean;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}

export interface ProductData {
    name: string;
    description: string;
    image_url: string | null;
    price: number;
    is_available: boolean;
    [key: string]: string | number | boolean | null | undefined;
}
