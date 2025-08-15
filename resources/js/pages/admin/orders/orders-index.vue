<script setup lang="ts">
import OrderBanner from '@/components/admin/orders/order-banner/order-banner.vue';
import OrderList from '@/components/admin/orders/order-list/order-list.vue';
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { Order } from '@/types/order';
import { Head } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Props {
    orders: Order[];
    statusCounts: Record<string, number>;
    allCount: number;
}

const props = defineProps<Props>();

const activeTab = ref('all');

const tabs = computed(() => [
    {
        key: 'all',
        label: 'All Orders',
        count: props.allCount,
    },
    {
        key: 'pending',
        label: 'Pending',
        count: props.statusCounts.pending || 0,
    },
    {
        key: 'processing',
        label: 'Processing',
        count: props.statusCounts.processing || 0,
    },
    {
        key: 'shipped',
        label: 'Shipped',
        count: props.statusCounts.shipped || 0,
    },
    {
        key: 'delivered',
        label: 'Delivered',
        count: props.statusCounts.delivered || 0,
    },
    {
        key: 'cancelled',
        label: 'Cancelled',
        count: props.statusCounts.cancelled || 0,
    },
]);

const filteredOrders = computed(() => {
    if (activeTab.value === 'all') {
        return props.orders;
    }
    return props.orders.filter((order) => order.status === activeTab.value);
});

const handleTabChange = (tab: string) => {
    activeTab.value = tab;
};
</script>

<template>
    <Head title="Orders - Admin" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Orders" subtitle="Manage customer orders and fulfillment" :icon="ShoppingCart" variant="primary" />

            <OrderBanner :tabs="tabs" :active-tab="activeTab" @tab-change="handleTabChange" />

            <OrderList :orders="filteredOrders" />
        </div>
    </sidebar-layout>
</template>
