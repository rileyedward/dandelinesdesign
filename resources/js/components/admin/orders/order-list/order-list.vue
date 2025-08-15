<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import type { Order } from '@/types/order';
import { Eye, User, CreditCard, Package } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

interface Props {
    orders: Order[];
}

defineProps<Props>();

const formatCurrency = (amount: number, currency: string = 'USD') => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency,
    }).format(amount);
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const getStatusBadgeClasses = (status: string) => {
    const variants: Record<string, string> = {
        pending: 'bg-yellow-100 text-yellow-800',
        processing: 'bg-blue-100 text-blue-800',
        shipped: 'bg-purple-100 text-purple-800',
        delivered: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800',
    };
    return variants[status] || 'bg-gray-100 text-gray-800';
};

const getPaymentStatusBadgeClasses = (status: string) => {
    const variants: Record<string, string> = {
        pending: 'bg-yellow-100 text-yellow-800',
        paid: 'bg-green-100 text-green-800',
        failed: 'bg-red-100 text-red-800',
        refunded: 'bg-gray-100 text-gray-800',
    };
    return variants[status] || 'bg-gray-100 text-gray-800';
};

const getCustomerName = (order: Order) => {
    const firstName = order.customer_first_name || '';
    const lastName = order.customer_last_name || '';
    return firstName && lastName ? `${firstName} ${lastName}` : order.customer_email;
};

const getTotalItems = (order: Order) => {
    return order?.line_items?.reduce((total, item) => total + item.quantity, 0);
};

const handleViewOrder = (orderId: number) => {
    router.visit(route('admin.orders.show', orderId));
};
</script>

<template>
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <div class="px-4 py-6 sm:px-6">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Orders</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">
                {{ orders.length }} order{{ orders.length !== 1 ? 's' : '' }} found
            </p>
        </div>

        <div v-if="orders.length === 0" class="px-4 py-12 text-center sm:px-6">
            <Package class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-semibold text-gray-900">No orders</h3>
            <p class="mt-1 text-sm text-gray-500">
                No orders found for the selected criteria.
            </p>
        </div>

        <div v-else class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                            Order
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                            Customer
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                            Items
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                            Payment
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                            Date
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center">
                                        <Package class="h-4 w-4 text-primary-600" />
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ order.order_number }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        ID: {{ order.id }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <User class="h-5 w-5 text-gray-400" />
                                </div>
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ getCustomerName(order) }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ order.customer_email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ getTotalItems(order) }} item{{ getTotalItems(order) !== 1 ? 's' : '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ formatCurrency(order.total_amount, order.currency) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="['inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize', getStatusBadgeClasses(order.status)]">
                                {{ order.status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <CreditCard class="h-4 w-4 text-gray-400 mr-1" />
                                <span :class="['inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize', getPaymentStatusBadgeClasses(order.payment_status)]">
                                    {{ order.payment_status }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ formatDate(order.created_at) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <UiButton
                                @click="handleViewOrder(order.id)"
                                variant="outline"
                                size="sm"
                                :icon="Eye"
                            >
                                View
                            </UiButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
