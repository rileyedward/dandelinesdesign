<script setup lang="ts">
import OrderInfo from '@/components/admin/orders/order-info/order-info.vue';
import OrderLineItems from '@/components/admin/orders/order-line-items/order-line-items.vue';
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import type { Order } from '@/types/order';
import { Head, router } from '@inertiajs/vue3';
import { ArrowLeft, Package } from 'lucide-vue-next';

interface Props {
    order: Order;
}

defineProps<Props>();

const handleBackClick = () => {
    router.visit(route('admin.orders.index'));
};
</script>

<template>
    <Head :title="`Order ${order.order_number} - Admin`" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header
                :title="`Order ${order.order_number}`"
                subtitle="Order details and management"
                :icon="Package"
                variant="primary"
            >
                <template #actions>
                    <ui-button
                        @click="handleBackClick"
                        variant="outline"
                        size="sm"
                        :prefix-icon="ArrowLeft"
                        label="Back to Orders"
                    />
                </template>
            </common-page-header>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <order-line-items :line-items="order.line_items" :currency="order.currency" />
                </div>
                <div class="lg:col-span-1">
                    <order-info :order="order" />
                </div>
            </div>
        </div>
    </sidebar-layout>
</template>
