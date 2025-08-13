<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { Testimonial } from '@/types/testimonial';

interface Props {
    testimonials: Testimonial[];
}

const props = defineProps<Props>();

const currentIndex = ref(0);
const currentTestimonial = ref<Testimonial>(props.testimonials[0]);

let rotationTimer: number | null = null;

const rotateTestimonial = () => {
    currentIndex.value = (currentIndex.value + 1) % props.testimonials.length;
    currentTestimonial.value = props.testimonials[currentIndex.value];
};

onMounted(() => {
    rotationTimer = window.setInterval(rotateTestimonial, 8000);
});

onBeforeUnmount(() => {
    if (rotationTimer !== null) {
        clearInterval(rotationTimer);
    }
});
</script>

<template>
    <div class="w-full bg-gray-200 py-12">
        <div class="container mx-auto px-4">
            <h2 class="mb-8 text-center text-3xl font-bold">Testimonials</h2>

            <div v-if="testimonials.length" class="mx-auto max-w-3xl">
                <div class="transition-opacity duration-500">
                    <p class="mb-6 text-center text-lg text-gray-700 italic">"{{ currentTestimonial.quote }}"</p>
                    <p class="text-center text-gray-600">— {{ currentTestimonial.name }}</p>
                </div>
            </div>
            <div v-else class="mx-auto max-w-3xl">
                <p class="text-center text-lg text-gray-700">No testimonials available at the moment.</p>
            </div>
        </div>
    </div>
</template>
