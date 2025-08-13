<script setup lang="ts">
import UiModal from '@/components/ui/feedback/modal/ui-modal.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import type { ContactMessage } from '@/types/contact-message';
import { useForm } from '@inertiajs/vue3';
import { Building, Calendar, Check, Copy, Mail, Phone } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    show: boolean;
    message: ContactMessage;
}>();

const emit = defineEmits<{
    (e: 'update:show', value: boolean): void;
    (e: 'updated'): void;
}>();

const form = useForm({
    name: props.message?.name || '',
    business_name: props.message?.business_name || '',
    email: props.message?.email || '',
    phone_number: props.message?.phone_number || '',
    subject: props.message?.subject || '',
    message: props.message?.message || '',
    is_read: props.message?.is_read || false,
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const toggleReadStatus = () => {
    form.is_read = !props.message.is_read;

    form.patch(route('admin.messages.update', props.message.id), {
        onSuccess: () => {
            emit('updated');
        },
    });
};

const copyToClipboard = async (text: string) => {
    if (!text) return;

    try {
        await navigator.clipboard.writeText(text);
    } catch (err) {
        console.error('Failed to copy text: ', err);
    }
};

const handleClose = () => {
    emit('update:show', false);
};

const emailCopied = ref(false);
const phoneCopied = ref(false);

const copyEmail = async () => {
    if (!props.message.email) return;

    await copyToClipboard(props.message.email);
    emailCopied.value = true;

    setTimeout(() => {
        emailCopied.value = false;
    }, 2000);
};

const copyPhone = async () => {
    if (!props.message.phone_number) return;

    await copyToClipboard(props.message.phone_number);
    phoneCopied.value = true;

    // Reset after 2 seconds
    setTimeout(() => {
        phoneCopied.value = false;
    }, 2000);
};
</script>

<template>
    <ui-modal
        :show="show"
        title="Contact Message"
        description="View message details and manage status"
        size="lg"
        @update:show="(value) => emit('update:show', value)"
    >
        <!-- Message Header -->
        <div class="mb-6 border-b border-gray-200 pb-4">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ message.name }}</h3>
                    <p v-if="message.business_name" class="flex items-center text-sm text-gray-600">
                        <Building class="mr-1 h-3 w-3" />
                        {{ message.business_name }}
                    </p>
                </div>
                <div :class="['rounded-full px-3 py-1 text-sm', message.is_read ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800']">
                    {{ message.is_read ? 'Read' : 'Unread' }}
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500">
                <Calendar class="mr-1 inline h-4 w-4" />
                {{ formatDate(message.created_at) }}
            </p>
        </div>

        <!-- Message Subject and Content -->
        <div class="mb-6">
            <h4 class="mb-2 text-lg font-medium text-gray-800">{{ message.subject }}</h4>
            <div class="rounded-lg bg-gray-50 p-4 text-gray-700">
                <p class="whitespace-pre-line">{{ message.message }}</p>
            </div>
        </div>

        <!-- Contact Information with Copy Buttons -->
        <div class="mb-6 space-y-3">
            <div v-if="message.email" class="flex items-center justify-between rounded-md border border-gray-200 p-3">
                <div class="flex items-center text-gray-700">
                    <Mail class="mr-2 h-5 w-5 text-gray-500" />
                    <span>{{ message.email }}</span>
                </div>
                <ui-button
                    :variant="emailCopied ? 'success' : 'secondary'"
                    size="sm"
                    :prefix-icon="emailCopied ? Check : Copy"
                    @click="copyEmail"
                >
                    {{ emailCopied ? 'Copied!' : 'Copy Email' }}
                </ui-button>
            </div>

            <div v-if="message.phone_number" class="flex items-center justify-between rounded-md border border-gray-200 p-3">
                <div class="flex items-center text-gray-700">
                    <Phone class="mr-2 h-5 w-5 text-gray-500" />
                    <span>{{ message.phone_number }}</span>
                </div>
                <ui-button
                    :variant="phoneCopied ? 'success' : 'secondary'"
                    size="sm"
                    :prefix-icon="phoneCopied ? Check : Copy"
                    @click="copyPhone"
                >
                    {{ phoneCopied ? 'Copied!' : 'Copy Phone' }}
                </ui-button>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            <ui-button
                :variant="message.is_read ? 'primary' : 'secondary'"
                @click="toggleReadStatus"
            >
                {{ message.is_read ? 'Mark as Unread' : 'Mark as Read' }}
            </ui-button>
            <ui-button
                variant="secondary"
                @click="handleClose"
            >
                Close
            </ui-button>
        </div>
    </ui-modal>
</template>
