<script setup lang="ts">
import { TestimonialBannerProps as Props, TestimonialBannerEmits as Emits } from '@/types/components/testimonial-banner';
import { formatDate } from '@/utils/date';

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const handleUpdate = () => {
    emit('update', props.testimonial);
};

const handleDelete = () => {
    emit('delete', props.testimonial.id);
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
                    class="rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                </button>
                <button
                    @click="handleDelete"
                    class="rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-gray-700">{{ props.testimonial.message }}</p>
        </div>
    </div>
</template>
