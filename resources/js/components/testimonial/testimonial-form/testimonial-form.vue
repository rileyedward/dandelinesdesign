<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiCheckbox from '@/components/ui/forms/checkbox/ui-checkbox.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiTextarea from '@/components/ui/forms/textarea/ui-textarea.vue';
import { Briefcase, Trash2, User } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { TestimonialFormEmits as Emits, TestimonialFormProps as Props } from './testimonial-form';

const props = withDefaults(defineProps<Props>(), {
    processing: false,
    errors: () => ({}),
});

const emit = defineEmits<Emits>();

const name = ref(props.testimonial?.name || '');
const title = ref(props.testimonial?.title || '');
const quote = ref(props.testimonial?.quote || '');
const is_featured = ref(props.testimonial?.is_featured || false);
const is_active = ref(props.testimonial?.is_active || true);

const isEditing = computed(() => !!props.testimonial);

const handleSubmit = () => {
    emit('submit', {
        name: name.value,
        title: title.value,
        quote: quote.value,
        is_featured: is_featured.value,
        is_active: is_active.value,
    });
};

const handleCancel = () => {
    emit('cancel');
};

const handleDelete = () => {
    emit('delete');
};
</script>

<template>
    <form @submit.prevent="handleSubmit" class="space-y-6">
        <div class="space-y-4">
            <ui-input
                v-model="name"
                type="text"
                label="Name"
                placeholder="Enter client name"
                :prefix-icon="User"
                :error-text="errors.name"
                :disabled="processing"
                required
                full-width
            />

            <ui-input
                v-model="title"
                type="text"
                label="Title"
                placeholder="Enter client title or position (optional)"
                :prefix-icon="Briefcase"
                :error-text="errors.title"
                :disabled="processing"
                full-width
            />

            <ui-textarea
                v-model="quote"
                label="Testimonial Quote"
                placeholder="Enter the testimonial quote"
                :error-text="errors.quote"
                :disabled="processing"
                required
                full-width
                :rows="4"
            />

            <div class="flex flex-col space-y-3">
                <ui-checkbox
                    v-model="is_featured"
                    label="Featured Testimonial"
                    description="Display this testimonial prominently on the website"
                    :error-text="errors.is_featured"
                    :disabled="processing"
                />

                <ui-checkbox
                    v-model="is_active"
                    label="Active Testimonial"
                    description="Show this testimonial on the website"
                    :error-text="errors.is_active"
                    :disabled="processing"
                />
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <ui-button
                v-if="isEditing"
                type="button"
                variant="danger"
                :prefix-icon="Trash2"
                :disabled="processing"
                @click="handleDelete"
            />
            <div class="flex-1"></div>
            <ui-button label="Cancel" type="button" variant="secondary" :disabled="processing" @click="handleCancel" />
            <ui-button label="Save" type="submit" variant="primary" :loading="processing" :disabled="processing" />
        </div>
    </form>
</template>
