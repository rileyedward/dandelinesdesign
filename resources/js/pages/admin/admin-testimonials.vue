<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminLayout from '@/layouts/admin-layout.vue';
import TestimonialBanner from '@/components/testimonials/testimonial-banner.vue';
import TestimonialUpdateModal from '@/components/testimonials/testimonial-update-modal.vue';
import { TestimonialsAdminPageProps as Props } from '@/types/pages/testimonials';
import { Testimonial, TestimonialData } from '@/types/models/testimonial';
import { Plus } from 'lucide-vue-next';

defineProps<Props>();

const selectedTestimonial = ref<Testimonial | null>(null);
const isModalOpen = ref<boolean>(false);

const openUpdateModal = (testimonial: Testimonial) => {
    selectedTestimonial.value = testimonial;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    // Reset selected testimonial after modal is closed
    setTimeout(() => {
        selectedTestimonial.value = null;
    }, 300);
};

const openCreateModal = () => {
    selectedTestimonial.value = null;
    isModalOpen.value = true;
};

const updateTestimonial = (id: number, data: TestimonialData) => {
    router.patch(`/admin/testimonials/${id}`, data);
};

const createTestimonial = (data: TestimonialData) => {
    router.post('/admin/testimonials', data);
};

const deleteTestimonial = (id: number) => {
    if (confirm('Are you sure you want to delete this testimonial?')) {
        router.delete(`/admin/testimonials/${id}`);
    }
};
</script>

<template>
    <admin-layout page-title="Testimonials" page-description="Manage customer testimonials and reviews">
        <div class="container mx-auto">
            <div class="mb-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold">All <span class="ml-2 rounded-full bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-800">{{ testimonials.length }}</span></h2>
                    <button
                        @click="openCreateModal"
                        class="rounded-md bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 hover:text-gray-800 focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 focus:outline-none"
                        title="Add Testimonial"
                    >
                        <Plus class="h-5 w-5" />
                    </button>
                </div>

                <div v-if="testimonials.length === 0" class="rounded-lg bg-gray-50 p-6 text-center">
                    <p class="text-gray-600">No testimonials found</p>
                </div>
                <div v-else>
                    <testimonial-banner
                        v-for="testimonial in testimonials"
                        :key="testimonial.id"
                        :testimonial="testimonial"
                        @update="openUpdateModal"
                        @delete="deleteTestimonial"
                    />
                </div>
            </div>
        </div>

        <!-- Update/Create Testimonial Modal -->
        <testimonial-update-modal
            :testimonial="selectedTestimonial"
            :is-open="isModalOpen"
            @close="closeModal"
            @update="updateTestimonial"
            @create="createTestimonial"
        />
    </admin-layout>
</template>
