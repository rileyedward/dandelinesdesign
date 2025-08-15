<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import type { NewsletterTemplate } from '@/types/newsletter-template';
import type { InertiaForm } from '@inertiajs/vue3';
import { AlertTriangle, CheckCircle, Mail, Send, Users, X } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    newsletterTemplate: NewsletterTemplate;
    form: InertiaForm<any>;
}

const props = defineProps<Props>();

const emit = defineEmits<{
    send: [];
    success: [];
}>();

const showConfirmDialog = ref(false);
const isSuccessVisible = ref(false);

const openConfirmDialog = () => {
    showConfirmDialog.value = true;
};

const closeConfirmDialog = () => {
    showConfirmDialog.value = false;
};

const handleSend = () => {
    emit('send');
    closeConfirmDialog();
};

const showSuccess = () => {
    isSuccessVisible.value = true;
    setTimeout(() => {
        isSuccessVisible.value = false;
    }, 5000);
};

// Watch for form success to show success message
const handleSuccess = () => {
    showSuccess();
    emit('success');
};

// Expose the success handler for parent components
defineExpose({
    handleSuccess,
});
</script>

<template>
    <div class="space-y-4">
        <!-- Send Newsletter Card -->
        <div class="rounded-lg border bg-white p-6 shadow-sm">
            <div class="flex items-start space-x-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
                    <Send class="h-5 w-5 text-blue-600" />
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">Send Newsletter</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Ready to send this newsletter template to your subscribers? This action cannot be undone.
                    </p>
                    <div class="mt-4 flex items-center space-x-6 text-sm text-gray-500">
                        <div class="flex items-center">
                            <Mail class="mr-1 h-4 w-4" />
                            <span class="font-medium">{{ newsletterTemplate.name }}</span>
                        </div>
                        <div class="flex items-center">
                            <Users class="mr-1 h-4 w-4" />
                            <span>All subscribers</span>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <ui-button
                        v-if="newsletterTemplate.status === 'draft'"
                        label="Send Newsletter"
                        variant="primary"
                        :prefix-icon="Send"
                        :loading="form.processing"
                        @click="openConfirmDialog"
                    />
                    <div v-else class="flex items-center text-sm text-green-600">
                        <CheckCircle class="mr-1 h-4 w-4" />
                        Already sent
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Dialog -->
        <div v-if="showConfirmDialog" class="bg-opacity-50 fixed inset-0 z-50 flex items-center justify-center bg-black">
            <div class="mx-4 w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                <div class="flex items-start space-x-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
                        <AlertTriangle class="h-5 w-5 text-red-600" />
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">Confirm Newsletter Send</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Are you absolutely sure you want to send this newsletter? This will immediately deliver the email to all subscribers and
                            cannot be undone.
                        </p>
                        <div class="mt-4 rounded-md bg-yellow-50 p-3">
                            <div class="flex">
                                <AlertTriangle class="h-5 w-5 text-yellow-400" />
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-yellow-800">Please verify:</h4>
                                    <ul class="mt-2 text-sm text-yellow-700">
                                        <li>• Subject: {{ newsletterTemplate.subject }}</li>
                                        <li>• Template: {{ newsletterTemplate.name }}</li>
                                        <li>• Recipients: All active subscribers</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex space-x-3">
                    <ui-button label="Cancel" variant="outline" class="flex-1" @click="closeConfirmDialog" />
                    <ui-button
                        label="Yes, Send Newsletter"
                        variant="destructive"
                        :prefix-icon="Send"
                        :loading="form.processing"
                        class="flex-1"
                        @click="handleSend"
                    />
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <div v-if="isSuccessVisible" class="fixed right-4 bottom-4 z-50 max-w-sm rounded-lg bg-green-50 p-4 shadow-lg ring-1 ring-green-200">
            <div class="flex items-start space-x-3">
                <CheckCircle class="h-5 w-5 text-green-600" />
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-green-800">Newsletter Sent Successfully!</h4>
                    <p class="mt-1 text-sm text-green-700">Your newsletter "{{ newsletterTemplate.name }}" has been sent to all subscribers.</p>
                </div>
                <button @click="isSuccessVisible = false" class="text-green-400 hover:text-green-600">
                    <X class="h-4 w-4" />
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Animation for success message */
.fixed {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
