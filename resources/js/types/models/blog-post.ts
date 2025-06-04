export interface BlogPost {
    id: number;
    title: string;
    slug: string;
    content: string;
    excerpt: string | null;
    image_url: string | null;
    is_published: boolean;
    created_at: string;
    updated_at: string;
    published_at: string | null;
    deleted_at: string | null;
}

export interface BlogPostData {
    title: string;
    content: string;
    image_url: string | null;
    is_published: boolean;
    [key: string]: string | boolean | null | undefined;
}
