import { BlogPost } from '@/types/models/blog-post';

export interface BlogIndexPageProps {
    blogPosts: BlogPost[];
}

export interface BlogShowPageProps {
    blogPost: BlogPost;
}
