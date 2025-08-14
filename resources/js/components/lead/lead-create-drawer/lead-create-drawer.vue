<script setup lang="ts">
import LeadForm from '@/components/lead/lead-form/lead-form.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiDrawer from '@/components/ui/layout/drawer/ui-drawer.vue';
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

const showDrawer = ref(false);

const emit = defineEmits<{
    (e: 'created'): void;
}>();

const form = useForm({
    name: '',
    email: '',
    phone_number: '',
    company: '',
    status: 'new',
    source: '',
    notes: '',
});

const handleSubmit = (lead: any) => {
    form.name = lead.name;
    form.email = lead.email;
    form.phone_number = lead.phone_number;
    form.company = lead.company;
    form.status = lead.status;
    form.source = lead.source;
    form.notes = lead.notes;

    form.post(route('admin.leads.store'), {
        onSuccess: () => {
            showDrawer.value = false;
            emit('created');
            form.reset();
        },
    });
};

const handleCancel = () => {
    showDrawer.value = false;
    form.reset();
};
</script>

<template>
    <div>
        <ui-button label="New" variant="primary" size="sm" :prefix-icon="Plus" @click="showDrawer = true" />

        <ui-drawer v-model:show="showDrawer" title="Create New Lead" description="Add a new lead to your CRM system" width="500px">
            <lead-form :processing="form.processing" :errors="form.errors" @submit="handleSubmit" @cancel="handleCancel" />
        </ui-drawer>
    </div>
</template>
