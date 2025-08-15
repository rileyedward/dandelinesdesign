<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiCard from '@/components/ui/layout/card/ui-card.vue';
import type { Order } from '@/types/order';
import { 
    User, 
    MapPin, 
    CreditCard, 
    Package, 
    Truck,
    CheckCircle,
    Phone,
    Mail,
    ExternalLink
} from 'lucide-vue-next';

interface Props {
    order: Order;
}

defineProps<Props>();

const formatCurrency = (amount: number, currency: string = 'USD') => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency,
    }).format(amount);
};

const formatDate = (dateString: string | null) => {
    if (!dateString) return 'N/A';
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
    return firstName && lastName ? `${firstName} ${lastName}` : 'N/A';
};

const getShippingAddress = (order: Order) => {
    const parts = [
        order.shipping_address_line_1,
        order.shipping_address_line_2,
        order.shipping_city,
        order.shipping_state,
        order.shipping_postal_code,
        order.shipping_country,
    ].filter(Boolean);
    
    return parts.length > 0 ? parts.join(', ') : 'N/A';
};

const getStripePaymentUrl = (paymentIntentId: string) => {
    const isTestMode = paymentIntentId.startsWith('pi_test_');
    const baseUrl = isTestMode 
        ? 'https://dashboard.stripe.com/test/payments'
        : 'https://dashboard.stripe.com/payments';
    return `${baseUrl}/${paymentIntentId}`;
};

const getStripeCustomerUrl = (customerId: string) => {
    const isTestMode = customerId.startsWith('cus_test_') || customerId.includes('test');
    const baseUrl = isTestMode 
        ? 'https://dashboard.stripe.com/test/customers'
        : 'https://dashboard.stripe.com/customers';
    return `${baseUrl}/${customerId}`;
};

const getStripeCheckoutUrl = (sessionId: string) => {
    const isTestMode = sessionId.startsWith('cs_test_');
    const baseUrl = isTestMode 
        ? 'https://dashboard.stripe.com/test/checkout/sessions'
        : 'https://dashboard.stripe.com/checkout/sessions';
    return `${baseUrl}/${sessionId}`;
};

const openStripeLink = (url: string) => {
    window.open(url, '_blank');
};
</script>

<template>
    <div class="space-y-6">
        <!-- Order Status -->
        <UiCard>
            <template #header>
                <div class="flex items-center">
                    <Package class="mr-2 h-5 w-5 text-gray-400" />
                    Order Status
                </div>
            </template>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Status</span>
                    <span :class="['inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize', getStatusBadgeClasses(order.status)]">
                        {{ order.status }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Payment</span>
                    <span :class="['inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize', getPaymentStatusBadgeClasses(order.payment_status)]">
                        {{ order.payment_status }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Created</span>
                    <span class="text-sm text-gray-900">{{ formatDate(order.created_at) }}</span>
                </div>
                <div v-if="order.shipped_at" class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Shipped</span>
                    <span class="text-sm text-gray-900">{{ formatDate(order.shipped_at) }}</span>
                </div>
                <div v-if="order.delivered_at" class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Delivered</span>
                    <span class="text-sm text-gray-900">{{ formatDate(order.delivered_at) }}</span>
                </div>
            </div>
        </UiCard>

        <!-- Customer Information -->
        <UiCard>
            <template #header>
                <div class="flex items-center">
                    <User class="mr-2 h-5 w-5 text-gray-400" />
                    Customer Information
                </div>
            </template>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Name</span>
                    <span class="text-sm text-gray-900">{{ getCustomerName(order) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <Mail class="mr-1 h-4 w-4 text-gray-400" />
                        <span class="text-sm font-medium text-gray-500">Email</span>
                    </div>
                    <span class="text-sm text-gray-900">{{ order.customer_email }}</span>
                </div>
                <div v-if="order.customer_phone" class="flex items-center justify-between">
                    <div class="flex items-center">
                        <Phone class="mr-1 h-4 w-4 text-gray-400" />
                        <span class="text-sm font-medium text-gray-500">Phone</span>
                    </div>
                    <span class="text-sm text-gray-900">{{ order.customer_phone }}</span>
                </div>
            </div>
        </UiCard>

        <!-- Shipping Information -->
        <UiCard>
            <template #header>
                <div class="flex items-center">
                    <MapPin class="mr-2 h-5 w-5 text-gray-400" />
                    Shipping Information
                </div>
            </template>
            <div class="space-y-4">
                <div>
                    <span class="text-sm font-medium text-gray-500">Address</span>
                    <p class="mt-1 text-sm text-gray-900">{{ getShippingAddress(order) }}</p>
                </div>
                <div v-if="order.shipping_method" class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Method</span>
                    <span class="text-sm text-gray-900">{{ order.shipping_method }}</span>
                </div>
                <div v-if="order.tracking_number" class="flex items-center justify-between">
                    <div class="flex items-center">
                        <Truck class="mr-1 h-4 w-4 text-gray-400" />
                        <span class="text-sm font-medium text-gray-500">Tracking</span>
                    </div>
                    <span class="text-sm text-gray-900 font-mono">{{ order.tracking_number }}</span>
                </div>
            </div>
        </UiCard>

        <!-- Payment Information -->
        <UiCard>
            <template #header>
                <div class="flex items-center">
                    <CreditCard class="mr-2 h-5 w-5 text-gray-400" />
                    Payment Information
                </div>
            </template>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Subtotal</span>
                    <span class="text-sm text-gray-900">{{ formatCurrency(order.subtotal, order.currency) }}</span>
                </div>
                <div v-if="order.tax_amount" class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Tax</span>
                    <span class="text-sm text-gray-900">{{ formatCurrency(order.tax_amount, order.currency) }}</span>
                </div>
                <div v-if="order.shipping_cost" class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Shipping</span>
                    <span class="text-sm text-gray-900">{{ formatCurrency(order.shipping_cost, order.currency) }}</span>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex items-center justify-between">
                        <span class="text-base font-medium text-gray-900">Total</span>
                        <span class="text-base font-bold text-gray-900">{{ formatCurrency(order.total_amount, order.currency) }}</span>
                    </div>
                </div>
                <div v-if="order.payment_method" class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-500">Method</span>
                    <span class="text-sm text-gray-900 capitalize">{{ order.payment_method }}</span>
                </div>
                <div v-if="order.payment_completed_at" class="flex items-center justify-between">
                    <div class="flex items-center">
                        <CheckCircle class="mr-1 h-4 w-4 text-green-500" />
                        <span class="text-sm font-medium text-gray-500">Paid At</span>
                    </div>
                    <span class="text-sm text-gray-900">{{ formatDate(order.payment_completed_at) }}</span>
                </div>
            </div>
        </UiCard>

        <!-- Stripe Information -->
        <UiCard v-if="order.stripe_checkout_session_id">
            <template #header>
                <div class="flex items-center">
                    <CreditCard class="mr-2 h-5 w-5 text-gray-400" />
                    Stripe Information
                </div>
            </template>
            <div class="space-y-4">
                <div v-if="order.stripe_checkout_session_id">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Checkout Session</span>
                        <UiButton
                            variant="outline"
                            size="xs"
                            :suffix-icon="ExternalLink"
                            @click="openStripeLink(getStripeCheckoutUrl(order.stripe_checkout_session_id!))"
                        >
                            View
                        </UiButton>
                    </div>
                    <p class="mt-1 text-xs text-gray-900 font-mono break-all">{{ order.stripe_checkout_session_id }}</p>
                </div>
                
                <div v-if="order.stripe_payment_intent_id">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Payment Intent</span>
                        <UiButton
                            variant="outline"
                            size="xs"
                            :suffix-icon="ExternalLink"
                            @click="openStripeLink(getStripePaymentUrl(order.stripe_payment_intent_id!))"
                        >
                            View
                        </UiButton>
                    </div>
                    <p class="mt-1 text-xs text-gray-900 font-mono break-all">{{ order.stripe_payment_intent_id }}</p>
                </div>
                
                <div v-if="order.stripe_customer_id">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Customer</span>
                        <UiButton
                            variant="outline"
                            size="xs"
                            :suffix-icon="ExternalLink"
                            @click="openStripeLink(getStripeCustomerUrl(order.stripe_customer_id!))"
                        >
                            View
                        </UiButton>
                    </div>
                    <p class="mt-1 text-xs text-gray-900 font-mono break-all">{{ order.stripe_customer_id }}</p>
                </div>
                
                <!-- Quick Actions -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="text-sm font-medium text-gray-500 mb-2">Quick Actions</div>
                    <div class="space-y-2">
                        <UiButton
                            v-if="order.stripe_payment_intent_id"
                            variant="outline"
                            size="sm"
                            :suffix-icon="ExternalLink"
                            @click="openStripeLink(getStripePaymentUrl(order.stripe_payment_intent_id!))"
                            class="w-full justify-center"
                        >
                            View Payment in Stripe
                        </UiButton>
                        <UiButton
                            v-if="order.stripe_customer_id"
                            variant="outline"
                            size="sm"
                            :suffix-icon="ExternalLink"
                            @click="openStripeLink(getStripeCustomerUrl(order.stripe_customer_id!))"
                            class="w-full justify-center"
                        >
                            View Customer in Stripe
                        </UiButton>
                    </div>
                </div>
            </div>
        </UiCard>
    </div>
</template>