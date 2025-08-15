export interface Product {
    id: number;
    stripe_product_id?: string;
    category_id: number;
    category?: Category;
    name: string;
    slug: string;
    description: string;
    image_url?: string;
    images?: string[];
    package_dimensions?: string;
    weight?: number;
    shippable: boolean;
    tax_code?: string;
    metadata?: Record<string, any>;
    unit_label?: string;
    is_active: boolean;
    is_featured: boolean;
    prices?: Price[];
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}

export interface Category {
    id: number;
    name: string;
    slug: string;
    description?: string;
    is_active: boolean;
    sort_order: number;
    created_at: string;
    updated_at: string;
}

export interface Price {
    id: number;
    stripe_price_id: string;
    product_id: number;
    active: boolean;
    currency: string;
    type: 'one_time' | 'recurring';
    unit_amount: number;
    unit_amount_decimal?: number;
    billing_scheme?: string;
    recurring?: {
        interval: string;
        interval_count: number;
        usage_type?: string;
    };
    usage_type?: string;
    tax_behavior?: boolean;
    nickname?: string;
    metadata?: Record<string, any>;
    stripe_created_at?: string;
    created_at: string;
    updated_at: string;
}
