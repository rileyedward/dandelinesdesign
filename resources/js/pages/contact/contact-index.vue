<script setup lang="ts">
import Background from '@/components/background/background.vue';
import ContactForm from '@/components/contact/contact-form.vue';
import QuoteForm from '@/components/contact/quote-form.vue';
import SocialLinks from '@/components/social-links/social-links.vue';
import AppLayout from '@/layouts/app-layout.vue';
import { ref } from 'vue';

const formType = ref<'contact' | 'quote'>('contact');

const toggleFormType = (type: 'contact' | 'quote') => {
    formType.value = type;
};
</script>

<template>
    <app-layout>
        <background imageUrl="/images/contact-background.jpg">
            <social-links />
        </background>

        <div id="contact-form-section" class="container mx-auto px-4 py-12">
            <div class="flex flex-col gap-8 md:flex-row">
                <div class="md:w-5/12">
                    <img src="/images/design-service.jpg" alt="Contact Us" class="object-covershadow-lg rounded-lg" />
                </div>

                <div class="md:w-7/12">
                    <div class="mb-6">
                        <div class="flex border-b border-gray-200">
                            <button
                                @click="toggleFormType('contact')"
                                class="px-4 py-2 font-medium"
                                :class="formType === 'contact' ? 'border-b-2 border-black' : ''"
                            >
                                Contact Form
                            </button>
                            <button
                                @click="toggleFormType('quote')"
                                class="px-4 py-2 font-medium"
                                :class="formType === 'quote' ? 'border-b-2 border-black' : ''"
                            >
                                Request a Quote
                            </button>
                        </div>
                    </div>

                    <transition name="fade" mode="out-in">
                        <contact-form v-if="formType === 'contact'" />
                        <quote-form v-else />
                    </transition>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
