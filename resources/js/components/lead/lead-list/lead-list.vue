<script setup lang="ts">
import type { TableColumn, TableRow } from '@/components/ui/layout/table/ui-table';
import UiTable from '@/components/ui/layout/table/ui-table.vue';
import type { Lead } from '@/types/lead';
import { Building, Calendar, Mail, Phone } from 'lucide-vue-next';
import { computed, h } from 'vue';
import type { LeadListProps as Props } from './lead-list';

const props = withDefaults(defineProps<Props>(), {
    loading: false,
    noDataText: 'No leads found',
    loadingText: 'Loading leads...',
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const getStatusBadge = (status: string) => {
    const classes = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium';

    switch (status?.toLowerCase()) {
        case 'new':
            return h('span', { class: `${classes} bg-blue-100 text-blue-800` }, 'New');
        case 'contacted':
            return h('span', { class: `${classes} bg-yellow-100 text-yellow-800` }, 'Contacted');
        case 'qualified':
            return h('span', { class: `${classes} bg-green-100 text-green-800` }, 'Qualified');
        case 'converted':
            return h('span', { class: `${classes} bg-purple-100 text-purple-800` }, 'Converted');
        case 'lost':
            return h('span', { class: `${classes} bg-red-100 text-red-800` }, 'Lost');
        default:
            return h('span', { class: `${classes} bg-gray-100 text-gray-800` }, status || 'Unknown');
    }
};

const getContactInfo = (email: string, phone: string) => {
    return h(
        'div',
        { class: 'space-y-1' },
        [
            h('div', { class: 'flex items-center text-sm text-gray-600' }, [h(Mail, { class: 'w-3 h-3 mr-1' }), email || 'No email']),
            phone ? h('div', { class: 'flex items-center text-sm text-gray-600' }, [h(Phone, { class: 'w-3 h-3 mr-1' }), phone]) : null,
        ].filter(Boolean),
    );
};

const getCompanyDisplay = (company: string) => {
    if (!company) return h('span', { class: 'text-gray-400 text-sm' }, 'No company');
    return h('div', { class: 'flex items-center text-sm text-gray-600' }, [h(Building, { class: 'w-3 h-3 mr-1' }), company]);
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
        key: 'contact',
        label: 'Contact Info',
        render: (value: any, row: TableRow) => {
            const lead = row._lead as Lead;
            return getContactInfo(lead.email, lead.phone_number);
        },
    },
    {
        key: 'company',
        label: 'Company',
        render: (value: string) => getCompanyDisplay(value),
    },
    {
        key: 'status',
        label: 'Status',
        align: 'center',
        render: (value: string) => getStatusBadge(value),
    },
    {
        key: 'created_at',
        label: 'Created',
        align: 'center',
        render: (value: string) => getDateDisplay(value),
    },
];

const tableData = computed<TableRow[]>(() => {
    return props.leads.map((lead) => ({
        id: lead.id,
        name: lead.name,
        contact: `${lead.email}|${lead.phone_number}`,
        company: lead.company,
        status: lead.status,
        created_at: lead.created_at,
        _lead: lead,
    }));
});

const handleRowClick = (row: TableRow) => {
    const lead = row._lead as Lead;
    window.location.href = `/admin/leads/${lead.id}`;
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
