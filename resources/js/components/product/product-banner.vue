<script setup lang="ts">
import { ProductBannerEmits as Emits, ProductBannerProps as Props } from '@/types/components/product-banner';
import { formatCurrency } from '@/utils/currency';
import { formatDate } from '@/utils/date';
import { Pencil, Trash2 } from 'lucide-vue-next';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const handleEdit = () => {
    emit('edit', props.product);
};

const handleDelete = () => {
    emit('delete', props.product.id);
};
</script>

<template>
    <div class="mb-4 rounded-lg border border-gray-200 bg-white p-6 shadow-md">
        <div class="flex justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ props.product.name }}</h3>
                <div class="mt-1 flex items-center space-x-3">
                    <span
                        :class="props.product.is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                        class="rounded-full px-2.5 py-0.5 text-xs font-medium"
                    >
                        {{ props.product.is_available ? 'Available' : 'Unavailable' }}
                    </span>
                    <span class="text-sm text-gray-600">
                        {{ formatCurrency(props.product.price) }}
                    </span>
                    <span class="text-sm text-gray-600"> Created on {{ formatDate(props.product.created_at, true) }} </span>
                </div>
            </div>
            <div class="flex items-start space-x-2">
                <button
                    @click="handleEdit"
                    class="rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                    title="Edit Product"
                >
                    <Pencil class="h-5 w-5" />
                </button>
                <button
                    @click="handleDelete"
                    class="rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                    title="Delete Product"
                >
                    <Trash2 class="h-5 w-5" />
                </button>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-gray-700">
                {{ props.product.description.substring(0, 150) + (props.product.description.length > 150 ? '...' : '') }}
            </p>
        </div>
    </div>
</template>
