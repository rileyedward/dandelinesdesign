export interface Product {
    id: number;
    name: string;
    slug: string;
    description: string;
    price: string;
    category_id: number;
    is_active: boolean;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
