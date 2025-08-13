<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiCheckbox from '@/components/ui/forms/checkbox/ui-checkbox.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiTextarea from '@/components/ui/forms/textarea/ui-textarea.vue';
import { AlignLeft, Hash, Tag } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { CategoryFormEmits as Emits, CategoryFormProps as Props } from './category-form';

const props = withDefaults(defineProps<Props>(), {
    processing: false,
    errors: () => ({}),
});

const emit = defineEmits<Emits>();

const name = ref(props.category?.name || '');
const slug = ref(props.category?.slug || '');
const description = ref(props.category?.description || '');
const sort_order = ref(props.category?.sort_order || 0);
const is_active = ref(props.category?.is_active || true);

const isEditing = computed(() => !!props.category);

const handleSubmit = () => {
    emit('submit', {
        name: name.value,
        slug: slug.value,
        description: description.value,
        sort_order: sort_order.value,
        is_active: is_active.value,
    });
};

const handleCancel = () => {
    emit('cancel');
};
</script>

<template>
    <form @submit.prevent="handleSubmit" class="space-y-6">
        <div class="space-y-4">
            <ui-input
                v-model="name"
                type="text"
                label="Name"
                placeholder="Enter category name"
                :prefix-icon="Tag"
                :error-text="errors.name"
                :disabled="processing"
                required
                full-width
            />

            <ui-input
                v-model="slug"
                type="text"
                label="Slug"
                placeholder="Enter category slug"
                :prefix-icon="Tag"
                :error-text="errors.slug"
                :disabled="processing"
                required
                full-width
            />

            <ui-textarea
                v-model="description"
                label="Description"
                placeholder="Enter category description"
                :prefix-icon="AlignLeft"
                :error-text="errors.description"
                :disabled="processing"
                full-width
                :rows="4"
            />

            <ui-input
                v-model="sort_order"
                type="number"
                label="Sort Order"
                placeholder="Enter sort order"
                :prefix-icon="Hash"
                :error-text="errors.sort_order"
                :disabled="processing"
                required
                full-width
            />

            <ui-checkbox
                v-model="is_active"
                label="Active Category"
                description="Show this category on the website"
                :error-text="errors.is_active"
                :disabled="processing"
            />
        </div>

        <div class="flex justify-end space-x-3">
            <ui-button label="Cancel" type="button" variant="secondary" :disabled="processing" @click="handleCancel" />
            <ui-button type="submit" variant="primary" :loading="processing" :disabled="processing">
                {{ isEditing ? 'Update' : 'Create' }} Category
            </ui-button>
        </div>
    </form>
</template>
