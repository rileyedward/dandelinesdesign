<script setup lang="ts">
import TestimonialForm from '@/components/testimonial/testimonial-form/testimonial-form.vue';
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import type { Testimonial } from '@/types/testimonial';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
    testimonial: Testimonial;
}>();

const emit = defineEmits<{
    (e: 'update:show', value: boolean): void;
    (e: 'updated'): void;
}>();

const form = useForm({
    name: props.testimonial?.name || '',
    title: props.testimonial?.title || '',
    quote: props.testimonial?.quote || '',
    rating: props.testimonial?.rating || 5,
    is_featured: props.testimonial?.is_featured || false,
    is_active: props.testimonial?.is_active || true,
});

const handleSubmit = (testimonial: any) => {
    form.name = testimonial.name;
    form.title = testimonial.title;
    form.quote = testimonial.quote;
    form.rating = testimonial.rating;
    form.is_featured = testimonial.is_featured;
    form.is_active = testimonial.is_active;

    form.patch(route('admin.testimonials.update', props.testimonial.id), {
        onSuccess: () => {
            emit('update:show', false);
            emit('updated');
        },
    });
};

const handleCancel = () => {
    emit('update:show', false);
};
</script>

<template>
    <ui-modal
        :show="show"
        title="Update Testimonial"
        description="Edit an existing client testimonial"
        size="lg"
        @update:show="(value) => emit('update:show', value)"
    >
        <testimonial-form
            :testimonial="testimonial"
            :processing="form.processing"
            :errors="form.errors"
            @submit="handleSubmit"
            @cancel="handleCancel"
        />
    </ui-modal>
</template>
