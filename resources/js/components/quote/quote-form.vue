<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    phone_number: '',
    service_type: 'floral_design',
    event_date: '',
    event_location: '',
    guest_count: null,
    budget: null,
    description: '',
});

const isSubmitting = ref(false);
const isSuccess = ref(false);

const serviceTypes = [
    { value: 'floral_design', label: 'Floral Design', icon: 'flower' },
    { value: 'event_planning', label: 'Event Planning', icon: 'calendar' },
    { value: 'both', label: 'Both Services', icon: 'both' },
];

const budgetRanges = [
    { value: 500, label: 'Under $500' },
    { value: 1000, label: '$500 - $1,000' },
    { value: 2500, label: '$1,000 - $2,500' },
    { value: 5000, label: '$2,500 - $5,000' },
    { value: 10000, label: '$5,000 - $10,000' },
    { value: 15000, label: '$10,000+' },
];

const submitForm = () => {
    if (isSubmitting.value) return;

    isSubmitting.value = true;
    form.post(route('quote.store'), {
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

const getServiceIcon = (type: string) => {
    switch (type) {
        case 'floral_design':
            return `
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.5 2.5L19 4"/>
                </svg>
            `;
        case 'event_planning':
            return `
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            `;
        case 'both':
            return `
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            `;
        default:
            return `<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
    }
};
</script>

<template>
    <div class="rounded-3xl bg-white p-8 shadow-2xl md:p-12">
        <div class="mb-8">
            <div class="mb-4 flex items-center">
                <div class="mr-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-amber-500 to-orange-600">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Request a Quote</h3>
                    <p class="text-gray-600">Let's bring your vision to life with a custom proposal</p>
                </div>
            </div>
            <div class="h-1 w-20 rounded-full bg-gradient-to-r from-amber-400 to-orange-500"></div>
        </div>

        <!-- Success Message -->
        <div v-if="isSuccess" class="mb-6 rounded-2xl border border-amber-200 bg-gradient-to-r from-amber-50 to-orange-50 p-4">
            <div class="flex items-center">
                <div class="mr-3 inline-flex h-8 w-8 items-center justify-center rounded-full bg-amber-500">
                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-amber-800">Quote request submitted successfully!</p>
                    <p class="text-sm text-amber-700">I'll review your request and get back to you with a custom proposal.</p>
                </div>
            </div>
        </div>

        <form @submit.prevent="submitForm" class="space-y-6">
            <!-- Contact Information -->
            <div class="rounded-2xl bg-gradient-to-br from-gray-50 to-stone-50 p-6">
                <h4 class="mb-4 text-lg font-semibold text-gray-900">Contact Information</h4>
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
                                class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-amber-500 focus:bg-amber-50/50 focus:ring-4 focus:ring-amber-500/10 focus:outline-none"
                                placeholder="Your full name"
                                :disabled="isSubmitting"
                            />
                        </div>
                        <p v-if="form.errors.name" class="mt-1 text-sm text-rose-600">{{ form.errors.name }}</p>
                    </div>

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
                                class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-amber-500 focus:bg-amber-50/50 focus:ring-4 focus:ring-amber-500/10 focus:outline-none"
                                placeholder="your@email.com"
                                :disabled="isSubmitting"
                            />
                        </div>
                        <p v-if="form.errors.email" class="mt-1 text-sm text-rose-600">{{ form.errors.email }}</p>
                    </div>

                    <!-- Phone -->
                    <div class="group relative md:col-span-2">
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
                                class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-amber-500 focus:bg-amber-50/50 focus:ring-4 focus:ring-amber-500/10 focus:outline-none"
                                placeholder="(555) 123-4567"
                                :disabled="isSubmitting"
                            />
                        </div>
                        <p v-if="form.errors.phone_number" class="mt-1 text-sm text-rose-600">{{ form.errors.phone_number }}</p>
                    </div>
                </div>
            </div>

            <!-- Service Type -->
            <div class="rounded-2xl bg-gradient-to-br from-gray-50 to-stone-50 p-6">
                <h4 class="mb-4 text-lg font-semibold text-gray-900">Service Selection</h4>
                <label class="mb-3 block text-sm font-semibold text-gray-700">
                    What services are you interested in? <span class="text-rose-500">*</span>
                </label>
                <div class="grid gap-3 md:grid-cols-3">
                    <div v-for="service in serviceTypes" :key="service.value" class="relative">
                        <input
                            v-model="form.service_type"
                            :id="service.value"
                            :value="service.value"
                            type="radio"
                            class="peer sr-only"
                            :disabled="isSubmitting"
                        />
                        <label
                            :for="service.value"
                            class="flex cursor-pointer items-center justify-center rounded-2xl border-2 border-gray-300 bg-white p-4 text-center transition-all duration-300 peer-checked:border-amber-500 peer-checked:bg-gradient-to-br peer-checked:from-amber-50 peer-checked:to-orange-50 peer-checked:text-amber-700 hover:border-amber-400 hover:bg-amber-50"
                        >
                            <div class="flex flex-col items-center">
                                <div
                                    class="mb-2 rounded-full bg-gradient-to-br from-amber-100 to-orange-100 p-2 peer-checked:from-amber-200 peer-checked:to-orange-200"
                                >
                                    <div v-html="getServiceIcon(service.value)" class="text-amber-600"></div>
                                </div>
                                <span class="text-sm font-semibold">{{ service.label }}</span>
                            </div>
                        </label>
                    </div>
                </div>
                <p v-if="form.errors.service_type" class="mt-2 text-sm text-rose-600">{{ form.errors.service_type }}</p>
            </div>

            <!-- Event Details -->
            <div class="rounded-2xl bg-gradient-to-br from-gray-50 to-stone-50 p-6">
                <h4 class="mb-4 text-lg font-semibold text-gray-900">Event Details</h4>
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Event Date -->
                    <div class="group relative">
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Event Date</label>
                        <div class="relative">
                            <div class="absolute top-1/2 left-3 -translate-y-1/2 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>
                            </div>
                            <input
                                v-model="form.event_date"
                                type="date"
                                class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-amber-500 focus:bg-amber-50/50 focus:ring-4 focus:ring-amber-500/10 focus:outline-none"
                                :disabled="isSubmitting"
                            />
                        </div>
                        <p v-if="form.errors.event_date" class="mt-1 text-sm text-rose-600">{{ form.errors.event_date }}</p>
                    </div>

                    <!-- Event Location -->
                    <div class="group relative">
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Event Location</label>
                        <div class="relative">
                            <div class="absolute top-1/2 left-3 -translate-y-1/2 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <input
                                v-model="form.event_location"
                                type="text"
                                class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-amber-500 focus:bg-amber-50/50 focus:ring-4 focus:ring-amber-500/10 focus:outline-none"
                                placeholder="City, venue, or address"
                                :disabled="isSubmitting"
                            />
                        </div>
                        <p v-if="form.errors.event_location" class="mt-1 text-sm text-rose-600">{{ form.errors.event_location }}</p>
                    </div>

                    <!-- Guest Count -->
                    <div class="group relative">
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Estimated Guest Count</label>
                        <div class="relative">
                            <div class="absolute top-1/2 left-3 -translate-y-1/2 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                            </div>
                            <input
                                v-model="form.guest_count"
                                type="number"
                                min="1"
                                class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-amber-500 focus:bg-amber-50/50 focus:ring-4 focus:ring-amber-500/10 focus:outline-none"
                                placeholder="50"
                                :disabled="isSubmitting"
                            />
                        </div>
                        <p v-if="form.errors.guest_count" class="mt-1 text-sm text-rose-600">{{ form.errors.guest_count }}</p>
                    </div>

                    <!-- Budget -->
                    <div class="group relative">
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Budget Range</label>
                        <div class="relative">
                            <div class="absolute top-1/2 left-3 -translate-y-1/2 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"
                                    />
                                </svg>
                            </div>
                            <select
                                v-model="form.budget"
                                class="w-full rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 transition-all duration-300 focus:border-amber-500 focus:bg-amber-50/50 focus:ring-4 focus:ring-amber-500/10 focus:outline-none"
                                :disabled="isSubmitting"
                            >
                                <option value="">Select budget range</option>
                                <option v-for="budget in budgetRanges" :key="budget.value" :value="budget.value">{{ budget.label }}</option>
                            </select>
                        </div>
                        <p v-if="form.errors.budget" class="mt-1 text-sm text-rose-600">{{ form.errors.budget }}</p>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="group relative">
                <label class="mb-2 block text-sm font-semibold text-gray-700"> Tell me about your vision <span class="text-rose-500">*</span> </label>
                <div class="relative">
                    <div class="absolute top-4 left-3 text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </div>
                    <textarea
                        v-model="form.description"
                        required
                        rows="5"
                        class="w-full resize-none rounded-2xl border border-gray-300 bg-white py-3 pr-4 pl-12 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-amber-500 focus:bg-amber-50/50 focus:ring-4 focus:ring-amber-500/10 focus:outline-none"
                        placeholder="Describe your event, style preferences, color themes, specific requirements, or any other details that will help me create the perfect proposal for you..."
                        :disabled="isSubmitting"
                    ></textarea>
                </div>
                <p v-if="form.errors.description" class="mt-1 text-sm text-rose-600">{{ form.errors.description }}</p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center pt-4">
                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="inline-flex items-center rounded-full bg-gradient-to-r from-amber-500 to-orange-600 px-8 py-4 text-lg font-bold text-white transition-all duration-300 hover:scale-105 hover:from-amber-600 hover:to-orange-700 hover:shadow-2xl disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:scale-100"
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
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                    {{ isSubmitting ? 'Sending Request...' : 'Request Quote' }}
                </button>
            </div>
        </form>
    </div>
</template>
