import type { BlogPost } from '@/types/blog';

export interface BlogGridProps {
    blogPosts: BlogPost[];
    loading?: boolean;
    noDataText?: string;
    loadingText?: string;
}
