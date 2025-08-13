export interface Category {
    id: number;
    name: string;
    slug: string;
    description: string;
    is_active: boolean;
    sort_order: number;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
