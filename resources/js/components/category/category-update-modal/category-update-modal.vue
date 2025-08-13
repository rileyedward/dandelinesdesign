<script setup lang="ts">
import CategoryForm from '@/components/category/category-form/category-form.vue';
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import type { Category } from '@/types/category';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
    category: Category;
}>();

const emit = defineEmits<{
    (e: 'update:show', value: boolean): void;
    (e: 'updated'): void;
}>();

const form = useForm({
    name: props.category?.name || '',
    slug: props.category?.slug || '',
    description: props.category?.description || '',
    sort_order: props.category?.sort_order || 0,
    is_active: props.category?.is_active || true,
});

const handleSubmit = (category: any) => {
    form.name = category.name;
    form.slug = category.slug;
    form.description = category.description;
    form.sort_order = category.sort_order;
    form.is_active = category.is_active;

    form.patch(route('admin.categories.update', props.category.id), {
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
        title="Update Category"
        description="Edit an existing product category"
        size="lg"
        @update:show="(value) => emit('update:show', value)"
    >
        <category-form
            :category="category"
            :processing="form.processing"
            :errors="form.errors"
            @submit="handleSubmit"
            @cancel="handleCancel"
        />
    </ui-modal>
</template>
