import type { Category } from '@/types/category';

export interface CategoryFormProps {
    category?: Category;
    processing?: boolean;
    errors?: Record<string, string>;
}

export interface CategoryFormEmits {
    (event: 'submit', category: Partial<Category>): void;
    (event: 'cancel'): void;
}
