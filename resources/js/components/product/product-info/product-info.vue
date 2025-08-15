<script setup lang="ts">
import { type Product } from '@/types/product';
import {
    CalendarIcon,
    CheckCircleIcon,
    DollarSignIcon,
    ImageIcon,
    PackageIcon,
    ScaleIcon,
    ShoppingCartIcon,
    StarIcon,
    TagIcon,
    TruckIcon,
    XCircleIcon,
} from 'lucide-vue-next';

interface Props {
    product: Product;
}

defineProps<Props>();

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const formatCurrency = (amount: number, currency: string = 'USD') => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency,
    }).format(amount);
};
</script>

<template>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="border-b border-gray-200 pb-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ product.name }}</h1>
                    <p class="mt-2 text-lg text-gray-600">{{ product.slug }}</p>
                </div>
                <div class="flex space-x-2">
                    <span
                        :class="
                            product.is_active
                                ? 'inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800'
                                : 'inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800'
                        "
                    >
                        <CheckCircleIcon v-if="product.is_active" class="mr-1 h-3 w-3" />
                        <XCircleIcon v-else class="mr-1 h-3 w-3" />
                        {{ product.is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <span
                        v-if="product.is_featured"
                        class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800"
                    >
                        <StarIcon class="mr-1 h-3 w-3" />
                        Featured
                    </span>
                    <span
                        v-if="!product.shippable"
                        class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800"
                    >
                        Digital
                    </span>
                </div>
            </div>
        </div>

        <!-- Images Section -->
        <div v-if="product.images?.length || product.image_url" class="space-y-4">
            <h2 class="flex items-center text-xl font-semibold text-gray-900">
                <ImageIcon class="mr-2 h-5 w-5" />
                Product Images
            </h2>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Primary Image -->
                <div v-if="product.image_url" class="relative">
                    <img :src="product.image_url" :alt="product.name" class="h-48 w-full rounded-lg object-cover shadow-sm" />
                    <div class="absolute top-2 left-2">
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-800">Primary</span>
                    </div>
                </div>

                <!-- Additional Images -->
                <div v-for="(image, index) in product.images" :key="index" class="relative">
                    <img :src="image" :alt="`${product.name} - Image ${index + 1}`" class="h-48 w-full rounded-lg object-cover shadow-sm" />
                    <div class="absolute top-2 left-2">
                        <span
                            class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-700"
                            >{{ index + 1 }}</span
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Basic Information -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-900">Product Information</h2>

                <div class="space-y-4 rounded-lg border border-gray-200 p-4">
                    <!-- Description -->
                    <div>
                        <label class="text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-sm whitespace-pre-wrap text-gray-900">{{ product.description || 'No description provided' }}</p>
                    </div>

                    <!-- Category -->
                    <div v-if="product.category">
                        <label class="text-sm font-medium text-gray-700">Category</label>
                        <div class="mt-1 flex items-center">
                            <TagIcon class="mr-2 h-4 w-4 text-gray-400" />
                            <span class="text-sm text-gray-900">{{ product.category.name }}</span>
                        </div>
                    </div>

                    <!-- Stripe Product ID -->
                    <div v-if="product.stripe_product_id">
                        <label class="text-sm font-medium text-gray-700">Stripe Product ID</label>
                        <p class="mt-1 font-mono text-sm text-gray-600">{{ product.stripe_product_id }}</p>
                    </div>

                    <!-- Unit Label -->
                    <div v-if="product.unit_label">
                        <label class="text-sm font-medium text-gray-700">Unit Label</label>
                        <p class="mt-1 text-sm text-gray-900">{{ product.unit_label }}</p>
                    </div>

                    <!-- Tax Code -->
                    <div v-if="product.tax_code">
                        <label class="text-sm font-medium text-gray-700">Tax Code</label>
                        <p class="mt-1 font-mono text-sm text-gray-600">{{ product.tax_code }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping & Physical Details -->
            <div class="space-y-4">
                <h2 class="flex items-center text-xl font-semibold text-gray-900">
                    <TruckIcon class="mr-2 h-5 w-5" />
                    Shipping Details
                </h2>

                <div class="space-y-4 rounded-lg border border-gray-200 p-4">
                    <!-- Shippable Status -->
                    <div>
                        <label class="text-sm font-medium text-gray-700">Shipping</label>
                        <div class="mt-1 flex items-center">
                            <span
                                :class="
                                    product.shippable
                                        ? 'inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800'
                                        : 'inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800'
                                "
                            >
                                {{ product.shippable ? 'Physical Product' : 'Digital Product' }}
                            </span>
                        </div>
                    </div>

                    <!-- Package Dimensions -->
                    <div v-if="product.package_dimensions">
                        <label class="text-sm font-medium text-gray-700">Package Dimensions</label>
                        <div class="mt-1 flex items-center">
                            <PackageIcon class="mr-2 h-4 w-4 text-gray-400" />
                            <span class="text-sm text-gray-900">{{ product.package_dimensions }}</span>
                        </div>
                    </div>

                    <!-- Weight -->
                    <div v-if="product.weight">
                        <label class="text-sm font-medium text-gray-700">Weight</label>
                        <div class="mt-1 flex items-center">
                            <ScaleIcon class="mr-2 h-4 w-4 text-gray-400" />
                            <span class="text-sm text-gray-900">{{ product.weight }} oz</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Information -->
        <div v-if="product.prices?.length" class="space-y-4">
            <h2 class="flex items-center text-xl font-semibold text-gray-900">
                <DollarSignIcon class="mr-2 h-5 w-5" />
                Pricing
            </h2>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div v-for="price in product.prices" :key="price.id" class="space-y-3 rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-gray-900">
                            {{ formatCurrency(price.unit_amount, price.currency) }}
                        </span>
                        <span
                            :class="
                                price.active
                                    ? 'inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800'
                                    : 'inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800'
                            "
                        >
                            {{ price.active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="space-y-2 text-sm">
                        <div v-if="price.nickname">
                            <span class="font-medium text-gray-700">Name:</span>
                            <span class="text-gray-900">{{ price.nickname }}</span>
                        </div>

                        <div>
                            <span class="font-medium text-gray-700">Type:</span>
                            <span
                                :class="
                                    price.type === 'recurring'
                                        ? 'inline-flex items-center rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800'
                                        : 'inline-flex items-center rounded-full border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-700'
                                "
                            >
                                {{ price.type === 'recurring' ? 'Subscription' : 'One-time' }}
                            </span>
                        </div>

                        <div v-if="price.type === 'recurring' && price.recurring">
                            <span class="font-medium text-gray-700">Billing:</span>
                            <span class="text-gray-900">
                                Every {{ price.recurring.interval_count > 1 ? price.recurring.interval_count : '' }} {{ price.recurring.interval
                                }}{{ price.recurring.interval_count > 1 ? 's' : '' }}
                            </span>
                        </div>

                        <div>
                            <span class="font-medium text-gray-700">Stripe ID:</span>
                            <span class="font-mono text-xs text-gray-600">{{ price.stripe_price_id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metadata -->
        <div v-if="product.metadata && Object.keys(product.metadata).length > 0" class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-900">Metadata</h2>

            <div class="rounded-lg border border-gray-200 p-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div v-for="(value, key) in product.metadata" :key="key" class="space-y-1">
                        <label class="text-sm font-medium text-gray-700 capitalize">{{ key.replace(/_/g, ' ') }}</label>
                        <p class="text-sm text-gray-900">{{ value }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order History Preview -->
        <div v-if="product.order_products?.length" class="space-y-4">
            <h2 class="flex items-center text-xl font-semibold text-gray-900">
                <ShoppingCartIcon class="mr-2 h-5 w-5" />
                Recent Orders
            </h2>

            <div class="rounded-lg border border-gray-200 p-4">
                <div class="mb-4 text-sm text-gray-600">
                    This product has been ordered {{ product.order_products.length }} time{{ product.order_products.length !== 1 ? 's' : '' }}
                </div>

                <div class="space-y-2">
                    <div
                        v-for="orderProduct in product.order_products.slice(0, 5)"
                        :key="orderProduct.id"
                        class="flex items-center justify-between border-b border-gray-100 py-2 last:border-b-0"
                    >
                        <div>
                            <span class="text-sm font-medium text-gray-900">Order #{{ orderProduct.order?.order_number || 'N/A' }}</span>
                            <span class="ml-2 text-sm text-gray-600">Qty: {{ orderProduct.quantity }}</span>
                        </div>
                        <span class="text-sm text-gray-600">{{ formatCurrency(orderProduct.unit_price) }}</span>
                    </div>
                </div>

                <div v-if="product.order_products.length > 5" class="mt-3 text-center">
                    <span class="text-sm text-gray-500">... and {{ product.order_products.length - 5 }} more orders</span>
                </div>
            </div>
        </div>

        <!-- Timestamps -->
        <div class="space-y-4">
            <h2 class="flex items-center text-xl font-semibold text-gray-900">
                <CalendarIcon class="mr-2 h-5 w-5" />
                Timeline
            </h2>

            <div class="space-y-3 rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Created</span>
                    <span class="text-sm text-gray-900">{{ formatDate(product.created_at) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Last Updated</span>
                    <span class="text-sm text-gray-900">{{ formatDate(product.updated_at) }}</span>
                </div>
                <div v-if="product.deleted_at" class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Deleted</span>
                    <span class="text-sm text-red-600">{{ formatDate(product.deleted_at) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
