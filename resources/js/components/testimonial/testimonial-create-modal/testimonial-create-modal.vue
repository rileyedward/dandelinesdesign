<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import TestimonialForm from '@/components/testimonial/testimonial-form/testimonial-form.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import { Plus } from 'lucide-vue-next';

const showModal = ref(false);

const form = useForm({
  name: '',
  title: '',
  quote: '',
  rating: 5,
  is_featured: false,
  is_active: true,
});

const handleSubmit = (testimonial: any) => {
  form.name = testimonial.name;
  form.title = testimonial.title;
  form.quote = testimonial.quote;
  form.rating = testimonial.rating;
  form.is_featured = testimonial.is_featured;
  form.is_active = testimonial.is_active;

  form.post(route('admin.testimonials.store'), {
    onSuccess: () => {
      showModal.value = false;
      form.reset();
    },
  });
};
</script>

<template>
  <div>
    <ui-button
        label="Add Testimonial"
        variant="primary"
        size="sm"
        :prefix-icon="Plus"
        @click="showModal = true"
    />

    <ui-modal
      :show="showModal"
      title="Create Testimonial"
      description="Add a new client testimonial to showcase on your website"
      size="lg"
      @update:show="(value) => showModal = value"
    >
      <testimonial-form
        :processing="form.processing"
        :errors="form.errors"
        @submit="handleSubmit"
        @cancel="() => showModal = false"
      />
    </ui-modal>
  </div>
</template>
