<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import { type Product } from '@/types/product';
import { router } from '@inertiajs/vue3';
import { EyeIcon, ImageIcon, PackageIcon, ScaleIcon, StarIcon } from 'lucide-vue-next';

interface Props {
    product: Product;
}

interface Emits {
    view: [product: Product];
}

const props = defineProps<Props>();
defineEmits<Emits>();

const goToShowPage = () => {
    router.visit(`/admin/products/${props.product.id}`);
};
</script>

<template>
    <div class="relative overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition-all duration-200 hover:shadow-md">
        <!-- Product Image -->
        <div class="aspect-square w-full overflow-hidden bg-gray-100">
            <img
                v-if="product.images?.length ? product.images[0] : product.image_url"
                :src="product.images?.length ? product.images[0] : product.image_url"
                :alt="product.name"
                class="h-full w-full object-cover object-center transition-transform duration-200 hover:scale-105"
            />
            <div v-else class="flex h-full w-full items-center justify-center bg-gray-100 text-gray-400">
                <ImageIcon class="h-12 w-12" />
            </div>
        </div>

        <!-- Product Info Overlay -->
        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-4 text-white">
            <div class="space-y-1">
                <!-- Product Name -->
                <h3 class="text-lg leading-tight font-semibold">
                    {{ product.name }}
                </h3>

                <!-- Price Display -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span v-if="product?.prices?.length" class="text-xl font-bold"> ${{ product.prices[0]?.unit_amount }} </span>
                        <span v-else class="text-sm text-gray-300"> Price not set </span>
                    </div>

                    <!-- Status Badges -->
                    <div class="flex space-x-1">
                        <span
                            v-if="product.is_featured"
                            class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800"
                        >
                            <StarIcon class="mr-1 h-3 w-3" />
                            Featured
                        </span>
                        <span
                            v-if="!product.shippable"
                            class="inline-flex items-center rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800"
                        >
                            Digital
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Indicator -->
        <div class="absolute top-2 right-2">
            <div v-if="!product.is_active" class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-800">
                Inactive
            </div>
        </div>

        <!-- Multiple Images Indicator -->
        <div v-if="product.images && product.images.length > 1" class="absolute top-2 left-2">
            <div class="inline-flex items-center rounded-full bg-black/50 px-2 py-1 text-xs font-medium text-white">
                <ImageIcon class="mr-1 h-3 w-3" />
                {{ product.images.length }}
            </div>
        </div>

        <!-- Action Overlay (shown on hover) -->
        <div class="absolute inset-0 cursor-pointer bg-black/40 opacity-0 transition-opacity duration-200 hover:opacity-100" @click="goToShowPage">
            <div class="flex h-full items-center justify-center">
                <UiButton :prefix-icon="EyeIcon" variant="secondary" size="sm" />
            </div>
        </div>

        <!-- Product Metadata (tooltip on hover) -->
        <div
            v-if="product.metadata || product.package_dimensions || product.weight"
            class="absolute bottom-2 left-2 opacity-0 transition-opacity duration-200 hover:opacity-100"
        >
            <div class="rounded bg-black/70 px-2 py-1 text-xs text-white">
                <div v-if="product.package_dimensions" class="flex items-center">
                    <PackageIcon class="mr-1 h-3 w-3" />
                    {{ product.package_dimensions }}
                </div>
                <div v-if="product.weight" class="flex items-center">
                    <ScaleIcon class="mr-1 h-3 w-3" />
                    {{ product.weight }}oz
                </div>
            </div>
        </div>
    </div>
</template>
