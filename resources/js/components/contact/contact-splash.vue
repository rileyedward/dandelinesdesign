<script setup lang="ts">
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
    <common-background
        imageUrl="/images/background/contact-bg.jpg"
        :enable-parallax="true"
        :overlay-opacity="0.3"
        overlay-color="rgba(6, 78, 59, 0.4)"
    >
        <div
            class="social-links-card max-w-xs rounded-2xl border border-white/20 bg-white/95 p-8 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:shadow-emerald-100/30"
        >
            <div class="mb-4 text-center">
                <div class="mx-auto mb-3 h-1 w-16 rounded-full bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                <h3 class="text-2xl font-bold text-gray-900">Connect with me!</h3>
            </div>

            <p class="mb-6 text-center text-sm leading-relaxed text-gray-700">
                I'd love to hear from you! Whether you have a question about my services, want to discuss your vision, or simply want to say hello,
                reach out through any of these platforms. Your creative journey is just a message away!
            </p>

            <div class="mb-6 flex flex-wrap justify-center gap-3">
                <a
                    v-for="link in socialLinks"
                    :key="link.name"
                    :href="link.url"
                    :title="link.name"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 text-emerald-700 transition-all duration-300 hover:scale-110 hover:from-emerald-200 hover:to-teal-200 hover:shadow-lg"
                >
                    <component :is="link.icon" class="h-5 w-5" />
                </a>
            </div>

            <div class="text-center">
                <button
                    @click="scrollToContactForm"
                    class="inline-flex items-center rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:scale-105 hover:from-emerald-600 hover:to-teal-700 hover:shadow-lg"
                >
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                        />
                    </svg>
                    Contact Me!
                </button>
            </div>
        </div>
    </common-background>
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
