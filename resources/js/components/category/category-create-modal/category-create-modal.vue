<script setup lang="ts">
import CategoryForm from '@/components/category/category-form/category-form.vue';
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

const showModal = ref(false);

const emit = defineEmits<{
    (e: 'created'): void;
}>();

const form = useForm({
    name: '',
    slug: '',
    description: '',
    sort_order: 0,
    is_active: true,
});

const handleSubmit = (category: any) => {
    form.name = category.name;
    form.slug = category.slug;
    form.description = category.description;
    form.sort_order = category.sort_order;
    form.is_active = category.is_active;

    form.post(route('admin.categories.store'), {
        onSuccess: () => {
            showModal.value = false;
            emit('created');
            form.reset();
        },
    });
};
</script>

<template>
    <div>
        <ui-button label="New" variant="primary" size="sm" :prefix-icon="Plus" @click="showModal = true" />

        <ui-modal
            :show="showModal"
            title="Create Category"
            description="Add a new product category"
            size="lg"
            @update:show="(value) => (showModal = value)"
        >
            <category-form :processing="form.processing" :errors="form.errors" @submit="handleSubmit" @cancel="() => (showModal = false)" />
        </ui-modal>
    </div>
</template>
