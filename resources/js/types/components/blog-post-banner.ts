import { BlogPost } from '@/types/models/blog-post';

export interface BlogPostBannerProps {
    blogPost: BlogPost;
}

export interface BlogPostBannerEmits {
    (e: 'edit', blogPost: BlogPost): void;
}
