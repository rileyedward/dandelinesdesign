<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiSelect from '@/components/ui/forms/select/ui-select.vue';
import UiTextarea from '@/components/ui/forms/textarea/ui-textarea.vue';
import { AlignLeft, Calendar, DollarSign, Mail, MapPin, Phone, Tag, Trash2, User, Users } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { QuoteRequestFormEmits as Emits, QuoteRequestFormProps as Props } from './quote-request-form';

const props = withDefaults(defineProps<Props>(), {
    processing: false,
    errors: () => ({}),
});

const emit = defineEmits<Emits>();

const name = ref(props.quoteRequest?.name || '');
const email = ref(props.quoteRequest?.email || '');
const phone_number = ref(props.quoteRequest?.phone_number || '');
const service_type = ref(props.quoteRequest?.service_type || 'floral_design');
const event_date = ref(props.quoteRequest?.event_date || '');
const event_location = ref(props.quoteRequest?.event_location || '');
const guest_count = ref(props.quoteRequest?.guest_count || null);
const budget = ref(props.quoteRequest?.budget || null);
const description = ref(props.quoteRequest?.description || '');
const status = ref(props.quoteRequest?.status || 'pending');
const notes = ref(props.quoteRequest?.notes || '');

const isEditing = computed(() => !!props.quoteRequest);

const statusOptions = [
    { label: 'Pending', value: 'pending' },
    { label: 'Contacted', value: 'contacted' },
    { label: 'Quoted', value: 'quoted' },
    { label: 'Completed', value: 'completed' },
    { label: 'Cancelled', value: 'cancelled' },
];

const serviceTypeOptions = [
    { label: 'Floral Design', value: 'floral_design' },
    { label: 'Event Planning', value: 'event_planning' },
    { label: 'Both', value: 'both' },
];

const handleSubmit = () => {
    emit('submit', {
        status: status.value,
        notes: notes.value,
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
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <ui-input v-model="name" type="text" label="Name" :prefix-icon="User" :error-text="errors.name" :disabled="true" readonly full-width />
                <ui-input
                    v-model="email"
                    type="email"
                    label="Email"
                    :prefix-icon="Mail"
                    :error-text="errors.email"
                    :disabled="true"
                    readonly
                    full-width
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <ui-input
                    v-model="phone_number"
                    type="tel"
                    label="Phone Number"
                    :prefix-icon="Phone"
                    :error-text="errors.phone_number"
                    :disabled="true"
                    readonly
                    full-width
                />
                <ui-select
                    v-model="service_type"
                    label="Service Type"
                    :options="serviceTypeOptions"
                    :error-text="errors.service_type"
                    :disabled="true"
                    readonly
                    full-width
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <ui-input
                    v-model="event_date"
                    type="text"
                    label="Event Date"
                    :prefix-icon="Calendar"
                    :error-text="errors.event_date"
                    :disabled="true"
                    readonly
                    full-width
                />
                <ui-input
                    v-model="event_location"
                    type="text"
                    label="Event Location"
                    :prefix-icon="MapPin"
                    :error-text="errors.event_location"
                    :disabled="true"
                    readonly
                    full-width
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <ui-input
                    v-model="guest_count"
                    type="number"
                    label="Guest Count"
                    :prefix-icon="Users"
                    :error-text="errors.guest_count"
                    :disabled="true"
                    readonly
                    full-width
                />
                <ui-input
                    v-model="budget"
                    type="number"
                    label="Budget"
                    :prefix-icon="DollarSign"
                    :error-text="errors.budget"
                    :disabled="true"
                    readonly
                    full-width
                />
            </div>

            <ui-textarea
                v-model="description"
                label="Description"
                :prefix-icon="AlignLeft"
                :error-text="errors.description"
                :disabled="true"
                readonly
                full-width
                :rows="3"
            />

            <ui-select
                v-model="status"
                label="Status"
                :options="statusOptions"
                :prefix-icon="Tag"
                :error-text="errors.status"
                :disabled="processing"
                required
                full-width
            />

            <ui-textarea
                v-model="notes"
                label="Notes"
                placeholder="Enter admin notes about this quote request"
                :prefix-icon="AlignLeft"
                :error-text="errors.notes"
                :disabled="processing"
                full-width
                :rows="3"
            />
        </div>

        <div class="flex justify-end space-x-3">
            <ui-button
                v-if="isEditing"
                label="Delete"
                type="button"
                variant="danger"
                :prefix-icon="Trash2"
                :disabled="processing"
                @click="handleDelete"
            />
            <div class="flex-1"></div>
            <ui-button label="Cancel" type="button" variant="secondary" :disabled="processing" @click="handleCancel" />
            <ui-button type="submit" variant="primary" :loading="processing" :disabled="processing"> Update Quote Request </ui-button>
        </div>
    </form>
</template>
