<script setup lang="ts">
import StoreProductInfo from '@/components/store/product-info/store-product-info.vue';
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import type { Product } from '@/types/product';

interface Props {
    show: boolean;
    product: Product | null;
}

interface Emits {
    close: [];
    'add-to-cart': [product: Product, quantity: number];
}

defineProps<Props>();
const emit = defineEmits<Emits>();

const handleClose = () => {
    emit('close');
};

const handleAddToCart = (product: Product, quantity: number) => {
    emit('add-to-cart', product, quantity);
};
</script>

<template>
    <UiModal :show="show" size="xl" @close="handleClose" :centered="true">
        <div v-if="product" class="max-h-[85vh] overflow-y-auto">
            <store-product-info :product="product" @add-to-cart="handleAddToCart" />
        </div>
    </UiModal>
</template>
