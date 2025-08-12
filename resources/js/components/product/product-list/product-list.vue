<script setup lang="ts">
import type { TableColumn, TableRow } from '@/components/ui/layout/table/ui-table';
import UiTable from '@/components/ui/layout/table/ui-table.vue';
import type { Product } from '@/types/product';
import { Calendar, CheckCircle, DollarSign, XCircle } from 'lucide-vue-next';
import { computed, h } from 'vue';
import type { ProductListProps as Props } from './product-list';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No products found',
    loadingText: 'Loading products...',
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

const getPriceDisplay = (price: string) => {
    return h('div', { class: 'flex items-center text-sm font-medium text-gray-900' }, [
        h(DollarSign, { class: 'w-3 h-3 mr-1' }),
        price || '0.00'
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
        key: 'price',
        label: 'Price',
        align: 'center',
        render: (value: string) => getPriceDisplay(value),
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
    return props.products.map((product) => ({
        id: product.id,
        name: product.name,
        slug: product.slug,
        description: product.description,
        price: product.price,
        category_id: product.category_id,
        is_active: product.is_active,
        created_at: product.created_at,
        updated_at: product.updated_at,
        deleted_at: product.deleted_at,
        _product: product,
    }));
});

const handleRowClick = (row: TableRow) => {
    const product = row._product as Product;
    window.location.href = `/admin/products/${product.id}`;
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