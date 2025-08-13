<script setup lang="ts">
import GenerateLeadButton from '@/components/lead/generate-lead-button/generate-lead-button.vue';
import QuoteRequestForm from '@/components/quote-request/quote-request-form/quote-request-form.vue';
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import type { QuoteRequest } from '@/types/quote-request';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    show: boolean;
    quoteRequest: QuoteRequest;
}>();

const emit = defineEmits<{
    (e: 'update:show', value: boolean): void;
    (e: 'updated'): void;
}>();

const generateQuoteRequestNotes = (quoteRequest: QuoteRequest): string => {
    return `Generated from Quote Request:
Service: ${quoteRequest.service_type}
Event Date: ${quoteRequest.event_date}
Location: ${quoteRequest.event_location}
Guest Count: ${quoteRequest.guest_count}
Budget: ${quoteRequest.budget}
Description: ${quoteRequest.description}
${quoteRequest.notes ? `Notes: ${quoteRequest.notes}` : ''}`;
};

const handleLeadGenerated = () => {
    // The redirect will be handled by the backend
    // We can close the modal
    emit('update:show', false);
};

const handleError = (errors: Record<string, string>) => {
    // Handle errors if needed
    console.error('Error generating lead:', errors);
};

const form = useForm({
    name: props.quoteRequest?.name || '',
    email: props.quoteRequest?.email || '',
    phone_number: props.quoteRequest?.phone_number || '',
    service_type: props.quoteRequest?.service_type || 'floral_design',
    event_date: props.quoteRequest?.event_date || '',
    event_location: props.quoteRequest?.event_location || '',
    guest_count: props.quoteRequest?.guest_count || null,
    budget: props.quoteRequest?.budget || null,
    description: props.quoteRequest?.description || '',
    status: props.quoteRequest?.status || 'pending',
    notes: props.quoteRequest?.notes || '',
});

const handleSubmit = (quoteRequest: Partial<QuoteRequest>) => {
    form.status = quoteRequest.status || 'pending';
    form.notes = quoteRequest.notes || '';

    form.patch(route('admin.quotes.update', props.quoteRequest.id), {
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
    if (confirm('Are you sure you want to delete this quote request? This action cannot be undone.')) {
        form.delete(route('admin.quotes.destroy', props.quoteRequest.id), {
            onSuccess: () => {
                emit('update:show', false);
                emit('updated');
            },
        });
    }
};
</script>

<template>
    <ui-modal
        :show="show"
        title="Update Quote Request"
        description="Update the status and add notes to this quote request"
        size="xl"
        @update:show="(value) => emit('update:show', value)"
    >
        <quote-request-form
            :quote-request="quoteRequest"
            :processing="form.processing"
            :errors="form.errors"
            @submit="handleSubmit"
            @cancel="handleCancel"
            @delete="handleDelete"
        />

        <template #footer>
            <div class="flex justify-between">
                <generate-lead-button
                    :name="quoteRequest.name"
                    :email="quoteRequest.email"
                    :phone_number="quoteRequest.phone_number"
                    :source="'website'"
                    :notes="generateQuoteRequestNotes(quoteRequest)"
                    @lead-generated="handleLeadGenerated"
                    @error="handleError"
                />

                <div class="flex gap-2">
                    <ui-button label="Cancel" type="button" variant="secondary" :disabled="form.processing" @click="handleCancel" />
                    <ui-button
                        type="submit"
                        variant="primary"
                        :loading="form.processing"
                        :disabled="form.processing"
                        @click="handleSubmit(quoteRequest)"
                    >
                        Update
                    </ui-button>
                </div>
            </div>
        </template>
    </ui-modal>
</template>
