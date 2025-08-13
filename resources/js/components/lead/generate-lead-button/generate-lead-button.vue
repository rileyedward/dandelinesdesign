<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import type { GenerateLeadButtonEmits as Emits, GenerateLeadButtonProps as Props } from './generate-lead-button';

const props = withDefaults(defineProps<Props>(), {
    variant: 'default',
    size: 'md',
    disabled: false,
    loading: false,
    source: 'website',
});

const emit = defineEmits<Emits>();

const form = useForm({
    name: props.name,
    email: props.email,
    phone_number: props.phone_number || '',
    company: props.company || '',
    status: 'new',
    source: props.source || 'website',
    notes: props.notes || '',
});

const generateLead = () => {
    form.post(route('admin.leads.store'), {
        onSuccess: (page) => {
            emit('leadGenerated', page.props.lead);
        },
        onError: (errors) => {
            emit('error', errors);
        },
    });
};
</script>

<template>
    <ui-button
        label="Generate Lead"
        :variant="variant"
        :size="size"
        :disabled="disabled || form.processing"
        @click="generateLead"
        class="generate-lead-button"
        :prefix-icon="Plus"
    >
        <span
            v-if="form.processing"
            class="ml-2 inline-block h-4 w-4 animate-spin rounded-full border-2 border-solid border-current border-r-transparent align-[-0.125em]"
        ></span>
    </ui-button>
</template>
