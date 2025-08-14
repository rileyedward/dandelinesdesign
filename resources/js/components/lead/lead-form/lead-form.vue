<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiSelect from '@/components/ui/forms/select/ui-select.vue';
import UiTextarea from '@/components/ui/forms/textarea/ui-textarea.vue';
import { AlignLeft, Building, ExternalLink, Mail, Phone, Tag, Trash2, User } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { LeadFormEmits as Emits, LeadFormProps as Props } from './lead-form';

const props = withDefaults(defineProps<Props>(), {
    processing: false,
    errors: () => ({}),
});

const emit = defineEmits<Emits>();

const name = ref(props.lead?.name || '');
const email = ref(props.lead?.email || '');
const phone_number = ref(props.lead?.phone_number || '');
const company = ref(props.lead?.company || '');
const status = ref(props.lead?.status || 'new');
const source = ref(props.lead?.source || '');
const notes = ref(props.lead?.notes || '');

const isEditing = computed(() => !!props.lead);

const statusOptions = [
    { label: 'New', value: 'new' },
    { label: 'Contacted', value: 'contacted' },
    { label: 'Qualified', value: 'qualified' },
    { label: 'Proposal', value: 'proposal' },
    { label: 'Won', value: 'won' },
    { label: 'Lost', value: 'lost' },
];

const sourceOptions = [
    { label: 'Website', value: 'website' },
    { label: 'Referral', value: 'referral' },
    { label: 'Social Media', value: 'social_media' },
    { label: 'Advertising', value: 'advertising' },
    { label: 'Other', value: 'other' },
];

const handleSubmit = () => {
    emit('submit', {
        name: name.value,
        email: email.value,
        phone_number: phone_number.value,
        company: company.value,
        status: status.value,
        source: source.value,
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
            <!-- Contact Information -->
            <div>
                <h3 class="mb-4 text-sm font-medium tracking-wide text-gray-900 uppercase">Contact Information</h3>
                <div class="space-y-4">
                    <ui-input
                        v-model="name"
                        type="text"
                        label="Full Name"
                        placeholder="Enter full name"
                        :prefix-icon="User"
                        :error-text="errors.name"
                        :disabled="processing"
                        required
                        full-width
                    />

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <ui-input
                            v-model="email"
                            type="email"
                            label="Email"
                            placeholder="Enter email address"
                            :prefix-icon="Mail"
                            :error-text="errors.email"
                            :disabled="processing"
                            required
                            full-width
                        />
                        <ui-input
                            v-model="phone_number"
                            type="tel"
                            label="Phone Number"
                            placeholder="Enter phone number"
                            :prefix-icon="Phone"
                            :error-text="errors.phone_number"
                            :disabled="processing"
                            full-width
                        />
                    </div>

                    <ui-input
                        v-model="company"
                        type="text"
                        label="Company"
                        placeholder="Enter company name"
                        :prefix-icon="Building"
                        :error-text="errors.company"
                        :disabled="processing"
                        full-width
                    />
                </div>
            </div>

            <!-- Lead Details -->
            <div>
                <h3 class="mb-4 text-sm font-medium tracking-wide text-gray-900 uppercase">Lead Details</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
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
                        <ui-select
                            v-model="source"
                            label="Source"
                            :options="sourceOptions"
                            :prefix-icon="ExternalLink"
                            :error-text="errors.source"
                            :disabled="processing"
                            full-width
                        />
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <h3 class="mb-4 text-sm font-medium tracking-wide text-gray-900 uppercase">Notes</h3>
                <ui-textarea
                    v-model="notes"
                    label="Notes"
                    placeholder="Enter any additional notes about this lead"
                    :prefix-icon="AlignLeft"
                    :error-text="errors.notes"
                    :disabled="processing"
                    full-width
                    :rows="4"
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
