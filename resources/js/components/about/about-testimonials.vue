<script setup lang="ts">
import { Testimonial } from '@/types/testimonial';
import { onBeforeUnmount, onMounted, ref } from 'vue';

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

const renderStars = (rating: number) => {
    const stars = [];
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 !== 0;

    for (let i = 0; i < fullStars; i++) {
        stars.push('★');
    }

    if (hasHalfStar) {
        stars.push('☆');
    }

    while (stars.length < 5) {
        stars.push('☆');
    }

    return stars;
};

const goToTestimonial = (index: number) => {
    currentIndex.value = index;
    currentTestimonial.value = props.testimonials[index];

    if (rotationTimer !== null) {
        clearInterval(rotationTimer);
        rotationTimer = window.setInterval(rotateTestimonial, 8000);
    }
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
    <div class="relative bg-gradient-to-b from-stone-100 to-slate-200 py-20">
        <div class="container mx-auto px-6">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-4xl font-bold tracking-tight text-gray-900">What Our Clients Say</h2>
                <div class="mx-auto h-1 w-24 bg-gradient-to-r from-rose-400 to-pink-500"></div>
                <p class="mt-4 text-lg text-gray-600">Hear from those who've experienced our creative touch</p>
            </div>

            <div v-if="testimonials.length" class="mx-auto max-w-4xl">
                <div class="relative overflow-hidden rounded-3xl bg-white p-8 shadow-2xl transition-all duration-500 md:p-12">
                    <div class="absolute top-0 left-0 h-full w-2 bg-gradient-to-b from-rose-400 to-pink-500"></div>

                    <div class="relative">
                        <div class="mb-8 flex justify-center">
                            <svg class="h-12 w-12 text-rose-200" fill="currentColor" viewBox="0 0 32 32">
                                <path
                                    d="M10 8c-3.3 0-6 2.7-6 6v10h10V14h-4c0-2.2 1.8-4 4-4V8zm12 0c-3.3 0-6 2.7-6 6v10h10V14h-4c0-2.2 1.8-4 4-4V8z"
                                />
                            </svg>
                        </div>

                        <div class="text-center transition-all duration-700">
                            <p class="mb-8 text-xl leading-relaxed text-gray-800 md:text-2xl">"{{ currentTestimonial.quote }}"</p>

                            <div class="mb-4 flex justify-center">
                                <div v-if="currentTestimonial.rating" class="flex items-center space-x-1">
                                    <span
                                        v-for="(star, index) in renderStars(currentTestimonial.rating)"
                                        :key="index"
                                        class="text-2xl"
                                        :class="star === '★' ? 'text-amber-400' : 'text-gray-300'"
                                    >
                                        {{ star }}
                                    </span>
                                </div>
                            </div>

                            <div class="text-center">
                                <p class="text-xl font-semibold text-gray-900">{{ currentTestimonial.name }}</p>
                                <p v-if="currentTestimonial.title" class="text-gray-600">{{ currentTestimonial.title }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="testimonials.length > 1" class="mt-8 flex justify-center space-x-3">
                    <button
                        v-for="(testimonial, index) in testimonials"
                        :key="testimonial.id"
                        @click="goToTestimonial(index)"
                        class="h-3 w-3 rounded-full transition-all duration-300"
                        :class="index === currentIndex ? 'w-8 bg-rose-400' : 'bg-gray-300 hover:bg-rose-200'"
                        :aria-label="`Go to testimonial ${index + 1}`"
                    ></button>
                </div>

                <div class="mt-12 grid gap-6 md:grid-cols-3">
                    <div class="rounded-2xl bg-white p-6 text-center shadow-lg">
                        <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-rose-100">
                            <svg class="h-6 w-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Passion-Driven</h3>
                        <p class="mt-2 text-gray-600">Every project is infused with genuine love and creativity</p>
                    </div>

                    <div class="rounded-2xl bg-white p-6 text-center shadow-lg">
                        <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-pink-100">
                            <svg class="h-6 w-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Detail-Oriented</h3>
                        <p class="mt-2 text-gray-600">Meticulous attention to every element that makes your vision shine</p>
                    </div>

                    <div class="rounded-2xl bg-white p-6 text-center shadow-lg">
                        <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
                            <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Innovative</h3>
                        <p class="mt-2 text-gray-600">Fresh ideas and creative solutions for every unique project</p>
                    </div>
                </div>
            </div>

            <div v-else class="mx-auto max-w-3xl rounded-2xl bg-white p-12 shadow-lg">
                <div class="text-center">
                    <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                            />
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-gray-900">Coming Soon</h3>
                    <p class="text-lg text-gray-600">Client testimonials will be featured here once available.</p>
                </div>
            </div>
        </div>
    </div>
</template>
