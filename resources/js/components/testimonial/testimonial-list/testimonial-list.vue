<script setup lang="ts">
import { Star, Calendar } from 'lucide-vue-next';
import type { TestimonialListProps as Props } from './testimonial-list';

defineProps<Props>();

const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};
</script>

<template>
  <div class="space-y-6">
    <div v-if="loading" class="text-center py-8 text-gray-500">
      {{ loadingText }}
    </div>

    <div v-else-if="testimonials.length === 0" class="text-center py-8 text-gray-500">
      {{ noDataText }}
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="testimonial in testimonials"
        :key="testimonial.id"
        class="bg-white rounded-lg shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:scale-105 hover:border-blue-300"
      >
        <div class="flex justify-between items-start mb-4">
          <div>
            <h3 class="text-lg font-semibold text-gray-900">{{ testimonial.name }}</h3>
            <p v-if="testimonial.title" class="text-sm text-gray-600">{{ testimonial.title }}</p>
          </div>
          <div v-if="testimonial.is_featured" class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
            Featured
          </div>
        </div>

        <div class="mb-4">
          <p class="text-gray-700 italic">"{{ testimonial.quote }}"</p>
        </div>

        <div class="flex justify-between items-center text-sm text-gray-500">
          <div class="flex items-center">
            <Calendar class="w-4 h-4 mr-1" />
            {{ formatDate(testimonial.created_at) }}
          </div>
          <div class="flex items-center">
            <template v-if="testimonial.rating">
              <div class="flex">
                <Star
                  v-for="i in testimonial.rating"
                  :key="i"
                  class="w-4 h-4 text-yellow-500 fill-current"
                />
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
