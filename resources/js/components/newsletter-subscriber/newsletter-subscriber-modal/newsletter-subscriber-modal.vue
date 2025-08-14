<script setup lang="ts">
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiSelect from '@/components/ui/forms/select/ui-select.vue';
import type { NewsletterSubscriber } from '@/types/newsletter-subscriber';
import { useForm } from '@inertiajs/vue3';
import { Calendar, Mail, Tag } from 'lucide-vue-next';

const props = defineProps<{
    show: boolean;
    subscriber: NewsletterSubscriber;
}>();

const emit = defineEmits<{
    (e: 'update:show', value: boolean): void;
    (e: 'updated'): void;
}>();

const form = useForm({
    email: props.subscriber?.email || '',
    first_name: props.subscriber?.first_name || '',
    last_name: props.subscriber?.last_name || '',
    status: props.subscriber?.status || 'active',
    source: props.subscriber?.source || '',
    tags: props.subscriber?.tags || [],
});

const statusOptions = [
    { label: 'Active', value: 'active' },
    { label: 'Inactive', value: 'inactive' },
    { label: 'Unsubscribed', value: 'unsubscribed' },
];

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const handleSubmit = () => {
    form.patch(route('admin.newsletter.subscribers.update', props.subscriber.id), {
        onSuccess: () => {
            emit('updated');
            emit('update:show', false);
        },
    });
};

const handleClose = () => {
    emit('update:show', false);
};

const handleDelete = () => {
    if (confirm('Are you sure you want to delete this subscriber? This action cannot be undone.')) {
        form.delete(route('admin.newsletter.subscribers.destroy', props.subscriber.id), {
            onSuccess: () => {
                emit('updated');
                emit('update:show', false);
            },
        });
    }
};

const getDisplayName = () => {
    if (props.subscriber.first_name && props.subscriber.last_name) {
        return `${props.subscriber.first_name} ${props.subscriber.last_name}`;
    } else if (props.subscriber.first_name) {
        return props.subscriber.first_name;
    } else if (props.subscriber.last_name) {
        return props.subscriber.last_name;
    }
    return props.subscriber.email;
};

const getStatusColor = (status: string) => {
    switch (status) {
        case 'active':
            return 'bg-green-100 text-green-800';
        case 'inactive':
            return 'bg-yellow-100 text-yellow-800';
        case 'unsubscribed':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};
</script>

<template>
    <ui-modal
        :show="show"
        title="Newsletter Subscriber"
        description="View and edit subscriber details"
        size="lg"
        @update:show="(value) => emit('update:show', value)"
    >
        <!-- Subscriber Header -->
        <div class="mb-6 border-b border-gray-200 pb-4">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ getDisplayName() }}</h3>
                    <p class="flex items-center text-sm text-gray-600">
                        <Mail class="mr-1 h-3 w-3" />
                        {{ subscriber.email }}
                    </p>
                </div>
                <div :class="getStatusColor(subscriber.status)" class="rounded-full px-3 py-1 text-sm font-medium">
                    {{ subscriber.status }}
                </div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-4 text-sm text-gray-500">
                <p class="flex items-center">
                    <Calendar class="mr-1 h-4 w-4" />
                    Subscribed: {{ formatDate(subscriber.created_at) }}
                </p>
                <p v-if="subscriber.source" class="flex items-center">
                    <Tag class="mr-1 h-4 w-4" />
                    Source: {{ subscriber.source }}
                </p>
            </div>
        </div>

        <!-- Edit Form -->
        <form @submit.prevent="handleSubmit" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <ui-input v-model="form.first_name" label="First Name" placeholder="Enter first name" :error="form.errors.first_name" />
                <ui-input v-model="form.last_name" label="Last Name" placeholder="Enter last name" :error="form.errors.last_name" />
            </div>

            <ui-input v-model="form.email" label="Email Address" type="email" placeholder="Enter email address" required :error="form.errors.email" />

            <div class="grid grid-cols-2 gap-4">
                <ui-select v-model="form.status" label="Status" :options="statusOptions" required :error="form.errors.status" />
                <ui-input v-model="form.source" label="Source" placeholder="e.g., website, popup" :error="form.errors.source" />
            </div>

            <!-- Tags Display -->
            <div v-if="subscriber.tags && subscriber.tags.length > 0">
                <label class="mb-2 block text-sm font-medium text-gray-700">Tags</label>
                <div class="flex flex-wrap gap-2">
                    <span
                        v-for="tag in subscriber.tags"
                        :key="tag"
                        class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-sm font-medium text-blue-700"
                    >
                        {{ tag }}
                    </span>
                </div>
            </div>

            <!-- Preferences Display -->
            <div v-if="subscriber.preferences && subscriber.preferences.length > 0">
                <label class="mb-2 block text-sm font-medium text-gray-700">Preferences</label>
                <div class="flex flex-wrap gap-2">
                    <span
                        v-for="preference in subscriber.preferences"
                        :key="preference"
                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-sm font-medium text-green-700"
                    >
                        {{ preference }}
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between pt-4">
                <ui-button type="button" variant="destructive" @click="handleDelete" :disabled="form.processing"> Delete Subscriber </ui-button>

                <div class="flex space-x-3">
                    <ui-button type="button" variant="secondary" @click="handleClose" :disabled="form.processing"> Cancel </ui-button>
                    <ui-button type="submit" variant="primary" :disabled="form.processing" :loading="form.processing"> Save Changes </ui-button>
                </div>
            </div>
        </form>
    </ui-modal>
</template>
