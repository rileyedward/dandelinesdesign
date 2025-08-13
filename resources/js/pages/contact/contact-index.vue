<script setup lang="ts">
import ContactForm from '@/components/contact/contact-form.vue';
import ContactSplash from '@/components/contact/contact-splash.vue';
import QuoteForm from '@/components/quote/quote-form.vue';
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import { ref } from 'vue';

const activeForm = ref<'contact' | 'quote'>('contact');

const setActiveForm = (form: 'contact' | 'quote') => {
    activeForm.value = form;
};
</script>

<template>
    <navbar-layout>
        <contact-splash />

        <div id="contact-form-section" class="bg-gradient-to-b from-slate-50 to-stone-100 py-20">
            <div class="container mx-auto px-6">
                <div class="mx-auto max-w-4xl">
                    <div class="mb-12 text-center">
                        <h2 class="mb-4 text-4xl font-bold tracking-tight text-gray-900">Get In Touch</h2>
                        <div class="mx-auto h-1 w-24 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                        <p class="mx-auto mt-4 max-w-2xl text-lg text-gray-600">
                            Ready to start your project? Choose the option that best fits your needs, and let's begin creating something beautiful
                            together.
                        </p>
                    </div>

                    <div class="mb-8 flex justify-center">
                        <div class="inline-flex rounded-full bg-white p-2 shadow-lg">
                            <button
                                @click="setActiveForm('contact')"
                                :class="[
                                    'rounded-full px-6 py-3 text-sm font-semibold transition-all duration-300',
                                    activeForm === 'contact'
                                        ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-md'
                                        : 'text-gray-600 hover:text-emerald-600',
                                ]"
                            >
                                <div class="flex items-center">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                        />
                                    </svg>
                                    Send a Message
                                </div>
                            </button>
                            <button
                                @click="setActiveForm('quote')"
                                :class="[
                                    'rounded-full px-6 py-3 text-sm font-semibold transition-all duration-300',
                                    activeForm === 'quote'
                                        ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-md'
                                        : 'text-gray-600 hover:text-amber-600',
                                ]"
                            >
                                <div class="flex items-center">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                    Request a Quote
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="relative">
                        <div
                            v-show="activeForm === 'contact'"
                            class="transition-all duration-500"
                            :class="activeForm === 'contact' ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'"
                        >
                            <contact-form />
                        </div>

                        <div
                            v-show="activeForm === 'quote'"
                            class="transition-all duration-500"
                            :class="activeForm === 'quote' ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'"
                        >
                            <quote-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </navbar-layout>
</template>
