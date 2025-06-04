<script setup lang="ts">
import Background from '@/components/background/background.vue';
import AppLayout from '@/layouts/app-layout.vue';
import { useContact } from '@/composables/use-contact';

const { form, errors, submitForm } = useContact();
</script>

<template>
    <app-layout>
        <background imageUrl="/images/contact-background.jpg">
            <div class="flex h-full items-center justify-center">
                <h1 class="text-4xl font-bold text-white">Contact Us</h1>
            </div>
        </background>

        <div class="container mx-auto px-4 py-12">
            <h2 class="mb-6 text-2xl font-semibold">Get In Touch</h2>
            <p class="mb-8">Fill out the form below and we'll get back to you as soon as possible.</p>

            <form @submit.prevent="submitForm" class="max-w-2xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-medium mb-1">Name *</label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                            required
                        >
                        <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                    </div>

                    <div>
                        <label for="business_name" class="block text-sm font-medium mb-1">Business Name</label>
                        <input
                            id="business_name"
                            v-model="form.business_name"
                            type="text"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        >
                        <p v-if="errors.business_name" class="mt-1 text-sm text-red-600">{{ errors.business_name }}</p>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium mb-1">Email *</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                            required
                        >
                        <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium mb-1">Phone</label>
                        <input
                            id="phone"
                            v-model="form.phone"
                            type="tel"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        >
                        <p v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ errors.phone }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="subject" class="block text-sm font-medium mb-1">Subject *</label>
                    <input
                        id="subject"
                        v-model="form.subject"
                        type="text"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        required
                    >
                    <p v-if="errors.subject" class="mt-1 text-sm text-red-600">{{ errors.subject }}</p>
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium mb-1">Message *</label>
                    <textarea
                        id="message"
                        v-model="form.message"
                        rows="5"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        required
                    ></textarea>
                    <p v-if="errors.message" class="mt-1 text-sm text-red-600">{{ errors.message }}</p>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary"
                    >
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </app-layout>
</template>
