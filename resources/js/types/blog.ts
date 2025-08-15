export interface BlogPost {
    id: number;
    title: string;
    slug: string;
    content: string;
    is_published: boolean;
    image_url?: string;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
