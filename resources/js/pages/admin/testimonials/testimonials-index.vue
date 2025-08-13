<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head } from '@inertiajs/vue3';
import { Star } from 'lucide-vue-next';
import { Testimonial } from '@/types/testimonial';
import TestimonialList from '@/components/testimonial/testimonial-list/testimonial-list.vue';
import TestimonialCreateModal from '@/components/testimonial/testimonial-create-modal/testimonial-create-modal.vue';

defineProps<{
    testimonials: Testimonial[];
}>();
</script>

<template>
    <Head title="Testimonials" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Testimonials" subtitle="Manage customer testimonials" :icon="Star" variant="warning">
                <template #actions>
                    <testimonial-create-modal />
                </template>
            </common-page-header>

            <testimonial-list :testimonials="testimonials" />
        </div>
    </sidebar-layout>
</template>
