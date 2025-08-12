import type { BlogPost } from '@/types/blog';

export interface BlogListProps {
    blogPosts: BlogPost[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}
