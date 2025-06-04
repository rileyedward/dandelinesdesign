<script setup lang="ts">
import { testimonialRotationInterval, testimonials } from '@/pages/about/testimonials.config';
import { Testimonial } from '@/types/components/testimonial';
import { onBeforeUnmount, onMounted, ref } from 'vue';

// State for the current testimonial
const currentIndex = ref(0);
const currentTestimonial = ref<Testimonial>(testimonials[0]);

// Timer reference for cleanup
let rotationTimer: number | null = null;

// Function to rotate to the next testimonial
const rotateTestimonial = () => {
    currentIndex.value = (currentIndex.value + 1) % testimonials.length;
    currentTestimonial.value = testimonials[currentIndex.value];
};

// Set up the rotation timer when the component is mounted
onMounted(() => {
    rotationTimer = window.setInterval(rotateTestimonial, testimonialRotationInterval);
});

// Clean up the timer when the component is unmounted
onBeforeUnmount(() => {
    if (rotationTimer !== null) {
        clearInterval(rotationTimer);
    }
});
</script>

<template>
    <div class="w-full bg-white py-12">
        <div class="container mx-auto px-4">
            <h2 class="mb-8 text-center text-3xl font-bold">Testimonials</h2>

            <div class="mx-auto max-w-3xl">
                <div class="transition-opacity duration-500">
                    <p class="mb-6 text-center text-lg text-gray-700 italic">"{{ currentTestimonial.text }}"</p>
                    <p class="text-center text-gray-600">— {{ currentTestimonial.author }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
