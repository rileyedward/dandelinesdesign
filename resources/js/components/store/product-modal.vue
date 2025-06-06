<script setup lang="ts">
import Modal from '@/components/modal/modal.vue';
import { ProductModalProps as Props } from '@/types/components/product-modal';
import { computed } from 'vue';

const props = defineProps<Props>();

const formattedPrice = computed(() => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(props.product.price);
});
</script>

<template>
    <modal :is-open="isOpen" :on-close="onClose" size="2xl">
        <div class="flex flex-col md:flex-row md:space-x-6">
            <div class="mb-4 md:mb-0 md:w-1/2">
                <div class="relative h-64 w-full overflow-hidden rounded-lg md:h-96">
                    <img v-if="product.image_url" :src="product.image_url" :alt="product.name" class="h-full w-full object-cover" />
                    <div v-else class="flex h-full w-full items-center justify-center bg-gray-200">
                        <span class="text-gray-400">No image available</span>
                    </div>
                </div>
            </div>

            <div class="md:w-1/2">
                <h2 class="mb-2 text-2xl font-bold text-gray-800">{{ product.name }}</h2>
                <p class="text-primary mb-4 text-xl font-semibold" style="color: #f59e0b">{{ formattedPrice }}</p>

                <div class="mb-6">
                    <h3 class="mb-2 text-lg font-semibold text-gray-700">Description</h3>
                    <p class="text-gray-600">{{ product.description }}</p>
                </div>

                <div class="mb-4">
                    <span
                        class="inline-block rounded-full px-3 py-1 text-sm font-semibold"
                        :class="product.is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                    >
                        {{ product.is_available ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
            </div>
        </div>
    </modal>
</template>
