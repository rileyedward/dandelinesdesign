<script setup lang="ts">
import { socialLinks } from './social-links.config';

const scrollToContactForm = () => {
  const contactFormSection = document.getElementById('contact-form-section');
  if (contactFormSection) {
    const yOffset = -20;
    const y = contactFormSection.getBoundingClientRect().top + window.pageYOffset + yOffset;

    window.scrollTo({
      top: y,
      behavior: 'smooth'
    });
  }
};
</script>

<template>
  <div class="social-links-card bg-white rounded-lg shadow-md p-6 max-w-xs">
    <h3 class="text-xl font-semibold mb-4 text-center">Connect with me!</h3>

    <p class="text-sm text-gray-600 mb-4 text-center">I'd love to hear from you! Whether you have a question about my services, want to discuss your vision, or simply want to say hello, reach out through any of these platforms. Your creative journey is just a message away!</p>

    <div class="flex flex-wrap justify-center gap-4 mb-4">
      <a
        v-for="link in socialLinks"
        :key="link.name"
        :href="link.url"
        :title="link.name"
        target="_blank"
        rel="noopener noreferrer"
        class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors"
      >
        <component
          :is="link.icon"
          class="w-5 h-5 text-gray-700"
        />
      </a>
    </div>

    <div class="text-center mt-4">
      <button
        @click="scrollToContactForm"
        class="px-4 py-2 rounded-md border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-100 transition-colors"
      >
        contact me!
      </button>
    </div>
  </div>
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
