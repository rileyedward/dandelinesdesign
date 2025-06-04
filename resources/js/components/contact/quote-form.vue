<script setup lang="ts">
import { QuoteData } from '@/types/models/quote';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { route } from 'ziggy-js';

const form = reactive<QuoteData>({
    name: '',
    business_name: null,
    email: '',
    phone: null,
    event_date: '',
    event_type: '',
    event_description: '',
    guest_count: 50,
    venue_name: null,
    venue_address: '',
    budget_range: '',
    special_requests: null,
});

const errors = reactive<Record<string, string>>({});

const resetForm = () => {
    form.name = '';
    form.business_name = null;
    form.email = '';
    form.phone = null;
    form.event_date = '';
    form.event_type = '';
    form.event_description = '';
    form.guest_count = 0;
    form.venue_name = null;
    form.venue_address = '';
    form.budget_range = '';
    form.special_requests = null;

    Object.keys(errors).forEach((key) => {
        delete errors[key];
    });
};

const submitForm = () => {
    router.post(route('quote.store'), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            resetForm();
        },
        onError: (err) => {
            Object.keys(err).forEach((key) => {
                errors[key] = err[key];
            });
        },
    });
};
</script>

<template>
    <form @submit.prevent="submitForm" class="mx-auto max-w-2xl">
        <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label for="name" class="mb-1 block text-sm font-medium">Name *</label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                />
                <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
            </div>

            <div>
                <label for="business_name" class="mb-1 block text-sm font-medium">Business Name</label>
                <input
                    id="business_name"
                    v-model="form.business_name"
                    type="text"
                    class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                />
                <p v-if="errors.business_name" class="mt-1 text-sm text-red-600">{{ errors.business_name }}</p>
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Email *</label>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                />
                <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
            </div>

            <div>
                <label for="phone" class="mb-1 block text-sm font-medium">Phone</label>
                <input
                    id="phone"
                    v-model="form.phone"
                    type="tel"
                    class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                />
                <p v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ errors.phone }}</p>
            </div>

            <div>
                <label for="event_date" class="mb-1 block text-sm font-medium">Event Date *</label>
                <input
                    id="event_date"
                    v-model="form.event_date"
                    type="date"
                    class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                />
                <p v-if="errors.event_date" class="mt-1 text-sm text-red-600">{{ errors.event_date }}</p>
            </div>

            <div>
                <label for="event_type" class="mb-1 block text-sm font-medium">Event Type *</label>
                <input
                    id="event_type"
                    v-model="form.event_type"
                    type="text"
                    class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                />
                <p v-if="errors.event_type" class="mt-1 text-sm text-red-600">{{ errors.event_type }}</p>
            </div>

            <div>
                <label for="guest_count" class="mb-1 block text-sm font-medium">Guest Count *</label>
                <input
                    id="guest_count"
                    v-model="form.guest_count"
                    type="number"
                    min="1"
                    class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                />
                <p v-if="errors.guest_count" class="mt-1 text-sm text-red-600">{{ errors.guest_count }}</p>
            </div>

            <div>
                <label for="venue_name" class="mb-1 block text-sm font-medium">Venue Name</label>
                <input
                    id="venue_name"
                    v-model="form.venue_name"
                    type="text"
                    class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                />
                <p v-if="errors.venue_name" class="mt-1 text-sm text-red-600">{{ errors.venue_name }}</p>
            </div>
        </div>

        <div class="mb-6">
            <label for="venue_address" class="mb-1 block text-sm font-medium">Venue Address</label>
            <input
                id="venue_address"
                v-model="form.venue_address"
                type="text"
                class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
            />
            <p v-if="errors.venue_address" class="mt-1 text-sm text-red-600">{{ errors.venue_address }}</p>
        </div>

        <div class="mb-6">
            <label for="budget_range" class="mb-1 block text-sm font-medium">Budget Range *</label>
            <select
                id="budget_range"
                v-model="form.budget_range"
                class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
            >
                <option value="">Select a budget range</option>
                <option value="$1,000 - $2,500">$1,000 - $2,500</option>
                <option value="$2,500 - $5,000">$2,500 - $5,000</option>
                <option value="$5,000 - $10,000">$5,000 - $10,000</option>
                <option value="$10,000+">$10,000+</option>
            </select>
            <p v-if="errors.budget_range" class="mt-1 text-sm text-red-600">{{ errors.budget_range }}</p>
        </div>

        <div class="mb-6">
            <label for="event_description" class="mb-1 block text-sm font-medium">Event Description *</label>
            <textarea
                id="event_description"
                v-model="form.event_description"
                rows="5"
                class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
            ></textarea>
            <p v-if="errors.event_description" class="mt-1 text-sm text-red-600">{{ errors.event_description }}</p>
        </div>

        <div class="mb-6">
            <label for="special_requests" class="mb-1 block text-sm font-medium">Special Requests</label>
            <textarea
                id="special_requests"
                v-model="form.special_requests"
                rows="3"
                class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
            ></textarea>
            <p v-if="errors.special_requests" class="mt-1 text-sm text-red-600">{{ errors.special_requests }}</p>
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="rounded-md border border-gray-300 bg-white px-6 py-2 text-black hover:bg-gray-100 focus:ring-2 focus:ring-white focus:outline-none"
            >
                Request Quote
            </button>
        </div>
    </form>
</template>
