<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    title?: string;
    description?: string;
}>();

const defaultTitle = 'Subscribe to Our Newsletter';
const defaultDescription = 'Stay updated with our latest designs, events, and creative inspirations delivered directly to your inbox.';

const form = useForm({
    email: '',
    name: '',
    status: 'active',
    source: 'website_subscription',
});

const isSubmitting = ref(false);
const isSuccess = ref(false);
const errorMessage = ref('');

const handleSubmit = () => {
    isSubmitting.value = true;
    errorMessage.value = '';

    form.post(route('newsletter.store'), {
        preserveScroll: true,
        onSuccess: () => {
            isSuccess.value = true;
            form.reset();
        },
        onError: (errors) => {
            if (errors.email) {
                errorMessage.value = errors.email;
            } else {
                errorMessage.value = 'An error occurred. Please try again.';
            }
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};
</script>

<template>
    <div class="bg-gradient-to-br from-amber-50 to-orange-50 py-20">
        <div class="container mx-auto px-6 text-center">
            <div class="mx-auto max-w-3xl">
                <h2 class="mb-6 text-4xl font-bold text-gray-900">{{ props.title || defaultTitle }}</h2>
                <p class="mb-8 text-xl text-gray-600">
                    {{ props.description || defaultDescription }}
                </p>

                <div v-if="!isSuccess" class="mx-auto max-w-md rounded-xl border border-amber-200/50 bg-amber-100 p-8 shadow-xl backdrop-blur-sm">
                    <form @submit.prevent="handleSubmit" class="space-y-5">
                        <div>
                            <input
                                v-model="form.email"
                                type="email"
                                placeholder="Your email address"
                                class="w-full rounded-lg border-0 bg-white/90 px-6 py-4 text-lg text-gray-800 shadow-sm focus:ring-2 focus:ring-amber-300"
                                required
                            />
                            <p v-if="form.errors.email" class="mt-1 text-left text-sm font-medium text-amber-800">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <div>
                            <input
                                v-model="form.name"
                                type="text"
                                placeholder="Name (optional)"
                                class="w-full rounded-lg border-0 bg-white/90 px-6 py-4 text-lg text-gray-800 shadow-sm focus:ring-2 focus:ring-amber-300"
                            />
                        </div>

                        <button
                            type="submit"
                            :disabled="isSubmitting || !form.email"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-amber-300 px-8 py-4 text-lg font-bold text-white transition-all duration-300 hover:scale-105 hover:shadow-xl disabled:opacity-70"
                        >
                            <svg v-if="isSubmitting" class="mr-3 h-5 w-5 animate-spin" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            <svg v-else class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>
                            {{ isSubmitting ? 'Subscribing...' : 'Subscribe Now' }}
                        </button>

                        <p v-if="errorMessage" class="mt-2 text-sm font-medium text-amber-800">
                            {{ errorMessage }}
                        </p>
                    </form>
                </div>

                <div v-else class="mx-auto max-w-md rounded-xl border border-amber-200/50 bg-white/80 p-8 shadow-xl">
                    <svg class="mx-auto mb-4 h-16 w-16 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mb-2 text-2xl font-bold text-gray-900">Thank You for Subscribing!</h3>
                    <p class="text-gray-600">You've been successfully added to our newsletter. We're excited to share our latest updates with you.</p>
                </div>
            </div>
        </div>
    </div>
</template>
