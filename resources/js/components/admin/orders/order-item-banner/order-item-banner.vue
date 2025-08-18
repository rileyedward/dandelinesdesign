<script setup lang="ts">
import type { Order } from '@/types/order';
import { router } from '@inertiajs/vue3';
import { Calendar, CreditCard, Package, ShoppingBag, User } from 'lucide-vue-next';

interface Props {
    order: Order;
}

const props = defineProps<Props>();

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

const handleClick = () => {
    router.visit(route('admin.orders.show', props.order.id));
};
</script>

<template>
    <div
        class="cursor-pointer rounded-lg border border-gray-200 bg-white p-6 shadow-md transition-all duration-300 hover:border-blue-300 hover:shadow-lg"
        @click="handleClick"
    >
        <div class="mb-4 flex items-start justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary-100 flex h-10 w-10 items-center justify-center rounded-lg">
                        <Package class="text-primary-600 h-5 w-5" />
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-gray-900">{{ order.order_number }}</h3>
                    <p class="text-sm text-gray-600">Order ID: {{ order.id }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span
                    :class="[
                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize',
                        getStatusBadgeClasses(order.status),
                    ]"
                >
                    {{ order.status }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            <!-- Customer Info -->
            <div class="flex items-center">
                <User class="mr-2 h-5 w-5 text-gray-400" />
                <div>
                    <div class="text-sm font-medium text-gray-900">{{ getCustomerName(order) }}</div>
                    <div class="text-xs text-gray-500">{{ order.customer_email }}</div>
                </div>
            </div>

            <!-- Items & Total -->
            <div class="flex items-center">
                <ShoppingBag class="mr-2 h-5 w-5 text-gray-400" />
                <div>
                    <div class="text-sm font-medium text-gray-900">
                        {{ formatCurrency(order.total_amount, order.currency) }}
                    </div>
                    <div class="text-xs text-gray-500">{{ getTotalItems(order) }} item{{ getTotalItems(order) !== 1 ? 's' : '' }}</div>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="flex items-center">
                <CreditCard class="mr-2 h-5 w-5 text-gray-400" />
                <div>
                    <span
                        :class="[
                            'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize',
                            getPaymentStatusBadgeClasses(order.payment_status),
                        ]"
                    >
                        {{ order.payment_status }}
                    </span>
                    <div class="mt-1 text-xs text-gray-500">Payment</div>
                </div>
            </div>
        </div>

        <div class="mt-4 flex items-center text-sm text-gray-500">
            <Calendar class="mr-1 h-4 w-4" />
            Created {{ formatDate(order.created_at) }}
        </div>
    </div>
</template>
