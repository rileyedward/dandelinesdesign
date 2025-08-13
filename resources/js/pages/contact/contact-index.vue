<script setup lang="ts">
import NavbarLayout from '@/layouts/navbar/navbar-layout.vue';
import CommonBackground from '@/components/common/common-background/common-background.vue';
import { socialLinks } from '@/pages/contact/contact-index.config';

const scrollToContactForm = () => {
    const contactFormSection = document.getElementById('contact-form-section');
    if (contactFormSection) {
        const yOffset = -20;
        const y = contactFormSection.getBoundingClientRect().top + window.pageYOffset + yOffset;

        window.scrollTo({
            top: y,
            behavior: 'smooth',
        });
    }
};
</script>

<template>
    <navbar-layout>
        <common-background imageUrl="/images/background/contact-bg.jpg">
            <div class="social-links-card max-w-xs rounded-lg bg-white p-6 shadow-md">
                <h3 class="mb-4 text-center text-xl font-semibold">Connect with me!</h3>

                <p class="mb-4 text-center text-sm text-gray-600">
                    I'd love to hear from you! Whether you have a question about my services, want to discuss your vision, or simply want to say hello, reach
                    out through any of these platforms. Your creative journey is just a message away!
                </p>

                <div class="mb-4 flex flex-wrap justify-center gap-4">
                    <a
                        v-for="link in socialLinks"
                        :key="link.name"
                        :href="link.url"
                        :title="link.name"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 transition-colors hover:bg-gray-200"
                    >
                        <component :is="link.icon" class="h-5 w-5 text-gray-700" />
                    </a>
                </div>

                <div class="mt-4 text-center">
                    <button
                        @click="scrollToContactForm"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100"
                    >
                        contact me!
                    </button>
                </div>
            </div>
        </common-background>
    </navbar-layout>
</template>

<style scoped>
.social-links-card {
    position: absolute;
    top: 50%;
    right: 10%;
    transform: translateY(-50%);
    z-index: 20;
}
</style>
