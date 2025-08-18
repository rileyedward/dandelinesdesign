<script setup lang="ts">
import OrderItemBanner from '@/components/admin/orders/order-item-banner/order-item-banner.vue';
import type { Order } from '@/types/order';
import { Package } from 'lucide-vue-next';

interface Props {
    orders: Order[];
}

defineProps<Props>();
</script>

<template>
    <div class="space-y-6">
        <div v-if="orders.length === 0" class="bg-white py-12 text-center shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <Package class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-semibold text-gray-900">No orders</h3>
            <p class="mt-1 text-sm text-gray-500">No orders found for the selected criteria.</p>
        </div>

        <div v-else class="grid grid-cols-1 gap-6">
            <order-item-banner v-for="order in orders" :key="order.id" :order="order" />
        </div>
    </div>
</template>
