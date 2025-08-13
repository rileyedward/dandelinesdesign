<script setup lang="ts">
import LeadForm from '@/components/lead/lead-form/lead-form.vue';
import UiDrawer from '@/components/ui/layout/drawer/ui-drawer.vue';
import type { Lead } from '@/types/lead';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
    lead: Lead;
}>();

const emit = defineEmits<{
    (e: 'update:show', value: boolean): void;
    (e: 'updated'): void;
}>();

const form = useForm({
    name: props.lead?.name || '',
    email: props.lead?.email || '',
    phone_number: props.lead?.phone_number || '',
    company: props.lead?.company || '',
    status: props.lead?.status || 'new',
    source: props.lead?.source || '',
    notes: props.lead?.notes || '',
});

const handleSubmit = (lead: any) => {
    form.name = lead.name;
    form.email = lead.email;
    form.phone_number = lead.phone_number;
    form.company = lead.company;
    form.status = lead.status;
    form.source = lead.source;
    form.notes = lead.notes;

    form.patch(route('admin.leads.update', props.lead.id), {
        onSuccess: () => {
            emit('update:show', false);
            emit('updated');
        },
    });
};

const handleCancel = () => {
    emit('update:show', false);
};

const handleDelete = () => {
    if (confirm('Are you sure you want to delete this lead? This action cannot be undone.')) {
        form.delete(route('admin.leads.destroy', props.lead.id), {
            onSuccess: () => {
                emit('update:show', false);
                emit('updated');
            },
        });
    }
};
</script>

<template>
    <ui-drawer
        :show="show"
        title="Update Lead"
        description="Edit lead information and status"
        width="500px"
        @update:show="(value) => emit('update:show', value)"
    >
        <lead-form
            :lead="lead"
            :processing="form.processing"
            :errors="form.errors"
            @submit="handleSubmit"
            @cancel="handleCancel"
            @delete="handleDelete"
        />
    </ui-drawer>
</template>
