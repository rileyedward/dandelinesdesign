<script setup lang="ts">
import UiCard from '@/components/ui/layout/card/ui-card.vue';
import type { LineItem } from '@/types/order';
import { Package, Image } from 'lucide-vue-next';

interface Props {
    lineItems: LineItem[];
    currency: string;
}

defineProps<Props>();

const formatCurrency = (amount: number, currency: string = 'USD') => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency,
    }).format(amount);
};

const getImageUrl = (item: LineItem) => {
    return item.product?.image_url || item.product_image_url;
};

const getProductName = (item: LineItem) => {
    return item.product?.name || item.product_name;
};

const getProductSku = (item: LineItem) => {
    return item.product?.sku || item.product_sku;
};
</script>

<template>
    <UiCard>
        <template #header>
            <div class="flex items-center">
                <Package class="mr-2 h-5 w-5 text-gray-400" />
                Order Items ({{ lineItems.length }})
            </div>
        </template>

        <div class="space-y-6">
            <div 
                v-for="item in lineItems" 
                :key="item.id"
                class="flex items-start space-x-4 border-b border-gray-200 pb-6 last:border-b-0 last:pb-0"
            >
                <!-- Product Image -->
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 overflow-hidden rounded-lg border border-gray-200">
                        <img
                            v-if="getImageUrl(item)"
                            :src="getImageUrl(item)"
                            :alt="getProductName(item)"
                            class="h-full w-full object-cover object-center"
                        />
                        <div 
                            v-else 
                            class="flex h-full w-full items-center justify-center bg-gray-50"
                        >
                            <Image class="h-6 w-6 text-gray-400" />
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">
                                {{ getProductName(item) }}
                            </h4>
                            
                            <div v-if="getProductSku(item)" class="mt-1">
                                <p class="text-xs text-gray-500">
                                    SKU: {{ getProductSku(item) }}
                                </p>
                            </div>

                            <div v-if="item.product_description" class="mt-2">
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    {{ item.product_description }}
                                </p>
                            </div>

                            <!-- Stripe Information -->
                            <div class="mt-2 space-y-1">
                                <div v-if="item.stripe_price_id" class="text-xs text-gray-500">
                                    Price ID: {{ item.stripe_price_id }}
                                </div>
                                <div v-if="item.stripe_product_id" class="text-xs text-gray-500">
                                    Product ID: {{ item.stripe_product_id }}
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="ml-6 text-right">
                            <div class="text-sm font-medium text-gray-900">
                                {{ formatCurrency(item.unit_price, currency) }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Qty: {{ item.quantity }}
                            </div>
                            <div class="text-sm font-bold text-gray-900 mt-2">
                                {{ formatCurrency(item.total_price, currency) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Summary -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-between">
                    <span class="text-base font-medium text-gray-900">
                        Total Items: {{ lineItems.reduce((sum, item) => sum + item.quantity, 0) }}
                    </span>
                    <span class="text-base font-bold text-gray-900">
                        {{ formatCurrency(lineItems.reduce((sum, item) => sum + (Number(item.total_price) || 0), 0), currency) }}
                    </span>
                </div>
            </div>
        </div>
    </UiCard>
</template>