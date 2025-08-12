<script setup lang="ts">
import type { TableColumn, TableRow } from '@/components/ui/layout/table/ui-table';
import UiTable from '@/components/ui/layout/table/ui-table.vue';
import type { Category } from '@/types/category';
import { Calendar, CheckCircle, Hash, XCircle } from 'lucide-vue-next';
import { computed, h } from 'vue';
import type { CategoryListProps as Props } from './category-list';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No categories found',
    loadingText: 'Loading categories...',
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const truncateDescription = (description: string, maxLength: number = 100) => {
    if (!description) return 'No description';
    if (description.length <= maxLength) return description;
    return description.substring(0, maxLength) + '...';
};

const getStatusBadge = (isActive: boolean) => {
    const classes = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium';

    if (isActive) {
        return h('span', { class: `${classes} bg-green-100 text-green-800` }, [h(CheckCircle, { class: 'w-3 h-3 mr-1' }), 'Active']);
    } else {
        return h('span', { class: `${classes} bg-red-100 text-red-800` }, [h(XCircle, { class: 'w-3 h-3 mr-1' }), 'Inactive']);
    }
};

const getSortOrderDisplay = (sortOrder: number) => {
    return h('div', { class: 'flex items-center text-sm text-gray-600' }, [
        h(Hash, { class: 'w-3 h-3 mr-1' }),
        sortOrder.toString()
    ]);
};

const getDateDisplay = (dateString: string) => {
    return h('div', { class: 'flex items-center text-sm text-gray-600' }, [h(Calendar, { class: 'w-4 h-4 mr-1' }), formatDate(dateString)]);
};

const columns: TableColumn[] = [
    {
        key: 'id',
        label: 'ID',
        width: '80px',
        align: 'center',
    },
    {
        key: 'name',
        label: 'Name',
        render: (value: string) => h('div', { class: 'font-medium text-gray-900' }, value),
    },
    {
        key: 'description',
        label: 'Description',
        render: (value: string) => h('div', { class: 'text-sm text-gray-600' }, truncateDescription(value)),
    },
    {
        key: 'sort_order',
        label: 'Sort Order',
        align: 'center',
        render: (value: number) => getSortOrderDisplay(value),
    },
    {
        key: 'is_active',
        label: 'Status',
        align: 'center',
        render: (value: boolean) => getStatusBadge(value),
    },
    {
        key: 'created_at',
        label: 'Created',
        align: 'center',
        render: (value: string) => getDateDisplay(value),
    },
];

const tableData = computed<TableRow[]>(() => {
    return props.categories.map((category) => ({
        id: category.id,
        name: category.name,
        slug: category.slug,
        description: category.description,
        sort_order: category.sort_order,
        is_active: category.is_active,
        created_at: category.created_at,
        updated_at: category.updated_at,
        deleted_at: category.deleted_at,
        _category: category,
    }));
});

const handleRowClick = (row: TableRow) => {
    const category = row._category as Category;
    window.location.href = `/admin/categories/${category.id}`;
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