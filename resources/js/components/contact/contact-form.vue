<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    business_name: '',
    email: '',
    phone_number: '',
    subject: '',
    message: '',
});

const isSubmitting = ref(false);
const isSuccess = ref(false);

const submitForm = () => {
    if (isSubmitting.value) return;

    isSubmitting.value = true;
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => {
            isSuccess.value = true;
            form.reset();
            setTimeout(() => {
                isSuccess.value = false;
            }, 5000);
        },
        onError: () => {
            console.error('Form submission failed');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};
</script>

<template>
    <div class="rounded-3xl bg-white p-8 shadow-2xl md:p-12">
        <div class="mb-8">
            <div class="mb-4 flex items-center">
                <div class="mr-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                        />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Send a Message</h3>
                    <p class="text-gray-600">Let's start a conversation about your vision</p>
                </div>
            </div>
            <div class="h-1 w-20 rounded-full bg-gradient-to-r from-emerald-400 to-teal-500"></div>
        </div>

        <!-- Success Message -->
        <div v-if="isSuccess" class="mb-6 rounded-2xl border border-emerald-200 bg-gradient-to-r from-emerald-50 to-teal-50 p-4">
            <div class="flex items-center">
                <div class="mr-3 inline-flex h-8 w-8 items-center justify-center rounded-full bg-emerald-500">
                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-emerald-800">Message sent successfully!</p>
                    <p class="text-sm text-emerald-700">I'll get back to you as soon as possible.</p>
                </div>
            </div>
        </div>

        <form @submit.prevent="submitForm" class="space-y-6">
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Name -->
                <div class="group relative">
                    <label class="mb-2 block text-sm font-semibold text-gray-700"> Name <span class="text-rose-500">*</span> </label>
                    <div class="relative">
                        <div class="absolute top-1/2 left-3 -translate-y-1/2 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                        </div>
                        <input
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-emerald-500 focus:bg-emerald-50/50 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none"
                            placeholder="Your full name"
                            :disabled="isSubmitting"
                        />
                    </div>
                    <p v-if="form.errors.name" class="mt-1 text-sm text-rose-600">{{ form.errors.name }}</p>
                </div>

                <!-- Business Name -->
                <div class="group relative">
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Business Name</label>
                    <div class="relative">
                        <div class="absolute top-1/2 left-3 -translate-y-1/2 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                />
                            </svg>
                        </div>
                        <input
                            v-model="form.business_name"
                            type="text"
                            class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-emerald-500 focus:bg-emerald-50/50 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none"
                            placeholder="Your business (optional)"
                            :disabled="isSubmitting"
                        />
                    </div>
                    <p v-if="form.errors.business_name" class="mt-1 text-sm text-rose-600">{{ form.errors.business_name }}</p>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <!-- Email -->
                <div class="group relative">
                    <label class="mb-2 block text-sm font-semibold text-gray-700"> Email <span class="text-rose-500">*</span> </label>
                    <div class="relative">
                        <div class="absolute top-1/2 left-3 -translate-y-1/2 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>
                        </div>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-emerald-500 focus:bg-emerald-50/50 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none"
                            placeholder="your@email.com"
                            :disabled="isSubmitting"
                        />
                    </div>
                    <p v-if="form.errors.email" class="mt-1 text-sm text-rose-600">{{ form.errors.email }}</p>
                </div>

                <!-- Phone -->
                <div class="group relative">
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Phone Number</label>
                    <div class="relative">
                        <div class="absolute top-1/2 left-3 -translate-y-1/2 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                />
                            </svg>
                        </div>
                        <input
                            v-model="form.phone_number"
                            type="tel"
                            class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-emerald-500 focus:bg-emerald-50/50 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none"
                            placeholder="(555) 123-4567"
                            :disabled="isSubmitting"
                        />
                    </div>
                    <p v-if="form.errors.phone_number" class="mt-1 text-sm text-rose-600">{{ form.errors.phone_number }}</p>
                </div>
            </div>

            <!-- Subject -->
            <div class="group relative">
                <label class="mb-2 block text-sm font-semibold text-gray-700"> Subject <span class="text-rose-500">*</span> </label>
                <div class="relative">
                    <div class="absolute top-1/2 left-3 -translate-y-1/2 text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"
                            />
                        </svg>
                    </div>
                    <input
                        v-model="form.subject"
                        type="text"
                        required
                        class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-emerald-500 focus:bg-emerald-50/50 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none"
                        placeholder="What would you like to discuss?"
                        :disabled="isSubmitting"
                    />
                </div>
                <p v-if="form.errors.subject" class="mt-1 text-sm text-rose-600">{{ form.errors.subject }}</p>
            </div>

            <!-- Message -->
            <div class="group relative">
                <label class="mb-2 block text-sm font-semibold text-gray-700"> Message <span class="text-rose-500">*</span> </label>
                <div class="relative">
                    <div class="absolute top-4 left-3 text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </div>
                    <textarea
                        v-model="form.message"
                        required
                        rows="5"
                        class="w-full resize-none rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-emerald-500 focus:bg-emerald-50/50 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none"
                        placeholder="Tell me about your project, ideas, or any questions you have..."
                        :disabled="isSubmitting"
                    ></textarea>
                </div>
                <p v-if="form.errors.message" class="mt-1 text-sm text-rose-600">{{ form.errors.message }}</p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center pt-4">
                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="inline-flex items-center rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-4 text-lg font-bold text-white transition-all duration-300 hover:scale-105 hover:from-emerald-600 hover:to-teal-700 hover:shadow-2xl disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:scale-100"
                >
                    <svg v-if="isSubmitting" class="mr-3 h-5 w-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                        />
                    </svg>
                    <svg v-else class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    {{ isSubmitting ? 'Sending...' : 'Send Message' }}
                </button>
            </div>
        </form>
    </div>
</template>
