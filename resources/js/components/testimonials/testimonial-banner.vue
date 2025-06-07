<script setup lang="ts">
import { TestimonialBannerEmits as Emits, TestimonialBannerProps as Props } from '@/types/components/testimonial-banner';
import { formatDate } from '@/utils/date';
import { Pencil } from 'lucide-vue-next';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const handleUpdate = () => {
    emit('update', props.testimonial);
};
</script>

<template>
    <div class="mb-4 rounded-lg border border-gray-200 bg-white p-6 shadow-md">
        <div class="flex justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ props.testimonial.name }}</h3>
                <p class="mt-2 text-sm text-gray-600">Added: {{ formatDate(props.testimonial.created_at) }}</p>
            </div>
            <div class="flex items-start space-x-2">
                <button
                    @click="handleUpdate"
                    class="rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                    title="Edit Testimonial"
                >
                    <Pencil class="h-5 w-5" />
                </button>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-gray-700">{{ props.testimonial.message }}</p>
        </div>
    </div>
</template>
