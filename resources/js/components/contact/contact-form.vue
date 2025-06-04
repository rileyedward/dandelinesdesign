<script setup lang="ts">
import { ContactMessageData } from '@/types/models/contact-message';
import { router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import { route } from 'ziggy-js';
import Modal from '@/components/modal/modal.vue';

const form = reactive<ContactMessageData>({
    name: '',
    business_name: null,
    email: '',
    phone: null,
    subject: '',
    message: '',
});

const errors = reactive<Record<string, string>>({});
const isModalOpen = ref(false);

const resetForm = () => {
    form.name = '';
    form.business_name = null;
    form.email = '';
    form.phone = null;
    form.subject = '';
    form.message = '';

    Object.keys(errors).forEach((key) => {
        delete errors[key];
    });
};

const closeModal = () => {
    isModalOpen.value = false;
};

const submitForm = () => {
    router.post(route('contact.store'), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            resetForm();
            isModalOpen.value = true;
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
    <form @submit.prevent="submitForm">
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
        </div>

        <div class="mb-6">
            <label for="subject" class="mb-1 block text-sm font-medium">Subject *</label>
            <input
                id="subject"
                v-model="form.subject"
                type="text"
                class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
            />
            <p v-if="errors.subject" class="mt-1 text-sm text-red-600">{{ errors.subject }}</p>
        </div>

        <div class="mb-6">
            <label for="message" class="mb-1 block text-sm font-medium">Message *</label>
            <textarea
                id="message"
                v-model="form.message"
                rows="5"
                class="focus:ring-primary w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
            ></textarea>
            <p v-if="errors.message" class="mt-1 text-sm text-red-600">{{ errors.message }}</p>
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="rounded-md border border-gray-300 bg-white px-6 py-2 text-black hover:bg-gray-100 focus:ring-2 focus:ring-white focus:outline-none"
            >
                Send Message
            </button>
        </div>
    </form>

    <modal :is-open="isModalOpen" :on-close="closeModal">
        <div class="text-center">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Thank you for sending a message</h3>
            <p class="text-gray-600">We'll get back to you as soon as possible.</p>
        </div>
    </modal>
</template>
