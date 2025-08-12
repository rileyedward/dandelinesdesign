<script setup lang="ts">
import { computed, h } from 'vue';
import UiTable from '@/components/ui/layout/table/ui-table.vue';
import type { TableColumn, TableRow } from '@/components/ui/layout/table/ui-table';
import type { BlogListProps as Props } from './blog-list';
import type { BlogPost } from '@/types/blog';
import { CheckCircle, XCircle, Calendar } from 'lucide-vue-next';

const props = withDefaults(defineProps<Props>(), {
  loading: false,
  noDataText: 'No blog posts found',
  loadingText: 'Loading blog posts...',
});

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};

const truncateContent = (content: string, maxLength: number = 100) => {
  if (content.length <= maxLength) return content;
  return content.substring(0, maxLength) + '...';
};

const getStatusBadge = (isPublished: boolean) => {
  const classes = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium';

  if (isPublished) {
    return h('span', { class: `${classes} bg-green-100 text-green-800` }, [
      h(CheckCircle, { class: 'w-3 h-3 mr-1' }),
      'Published',
    ]);
  } else {
    return h('span', { class: `${classes} bg-yellow-100 text-yellow-800` }, [
      h(XCircle, { class: 'w-3 h-3 mr-1' }),
      'Draft',
    ]);
  }
};

const getDateDisplay = (dateString: string) => {
  return h('div', { class: 'flex items-center text-sm text-gray-600' }, [
    h(Calendar, { class: 'w-4 h-4 mr-1' }),
    formatDate(dateString),
  ]);
};


const columns: TableColumn[] = [
  {
    key: 'id',
    label: 'ID',
    width: '80px',
    align: 'center'
  },
  {
    key: 'title',
    label: 'Title',
    render: (value: string) => h('div', { class: 'font-medium text-gray-900' }, value)
  },
  {
    key: 'content',
    label: 'Content',
    render: (value: string) => h('div', { class: 'text-sm text-gray-600' }, truncateContent(value))
  },
  {
    key: 'is_published',
    label: 'Status',
    align: 'center',
    render: (value: boolean) => getStatusBadge(value)
  },
  {
    key: 'created_at',
    label: 'Created',
    align: 'center',
    render: (value: string) => getDateDisplay(value)
  },
];

const tableData = computed<TableRow[]>(() => {
  return props.blogPosts.map(post => ({
    id: post.id,
    title: post.title,
    slug: post.slug,
    content: post.content,
    is_published: post.is_published,
    created_at: post.created_at,
    updated_at: post.updated_at,
    deleted_at: post.deleted_at,
    _post: post,
  }));
});

const handleRowClick = (row: TableRow) => {
  const post = row._post as BlogPost;
  window.location.href = `/admin/blog/${post.id}`;
};

</script>

<template>
  <ui-table
    :columns="columns"
    :data="tableData"
    :loading="loading"
    :no-data-text="noDataText"
    :loading-text="loadingText"
    hoverable
    @row-click="handleRowClick"
  />
</template>
