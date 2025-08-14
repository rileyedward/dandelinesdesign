<script setup lang="ts">
import TestimonialUpdateModal from '@/components/testimonial/testimonial-update-modal/testimonial-update-modal.vue';
import type { Testimonial } from '@/types/testimonial';
import { Calendar, Star } from 'lucide-vue-next';
import { ref } from 'vue';
import type { TestimonialListProps as Props } from './testimonial-list';

defineProps<Props>();

const showUpdateModal = ref(false);
const selectedTestimonial = ref<Testimonial | null>(null);

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const handleTestimonialClick = (testimonial: Testimonial) => {
    selectedTestimonial.value = testimonial;
    showUpdateModal.value = true;
};

const handleTestimonialUpdated = () => {
    window.location.reload();
};
</script>

<template>
    <div class="space-y-6">
        <div v-if="loading" class="py-8 text-center text-gray-500">
            {{ loadingText }}
        </div>

        <div v-else-if="testimonials.length === 0" class="py-8 text-center text-gray-500">
            {{ noDataText }}
        </div>

        <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="testimonial in testimonials"
                :key="testimonial.id"
                class="cursor-pointer rounded-lg border border-gray-200 bg-white p-6 shadow-md transition-all duration-300 hover:scale-105 hover:border-blue-300 hover:shadow-lg"
                @click="handleTestimonialClick(testimonial)"
            >
                <div class="mb-4 flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ testimonial.name }}</h3>
                        <p v-if="testimonial.title" class="text-sm text-gray-600">{{ testimonial.title }}</p>
                    </div>
                    <div v-if="testimonial.is_featured" class="rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-800">Featured</div>
                </div>

                <div class="mb-4">
                    <p class="text-gray-700 italic">"{{ testimonial.quote }}"</p>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-500">
                    <div class="flex items-center">
                        <Calendar class="mr-1 h-4 w-4" />
                        {{ formatDate(testimonial.created_at) }}
                    </div>
                </div>
            </div>
        </div>

        <testimonial-update-modal
            v-if="selectedTestimonial"
            v-model:show="showUpdateModal"
            :testimonial="selectedTestimonial"
            @updated="handleTestimonialUpdated"
        />
    </div>
</template>
