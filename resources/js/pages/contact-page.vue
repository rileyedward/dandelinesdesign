<script setup lang="ts">
import Background from '@/components/background/background.vue';
import ContactForm from '@/components/contact-form.vue';
import AppLayout from '@/layouts/app-layout.vue';
</script>

<template>
    <app-layout>
        <background imageUrl="/images/contact-background.jpg">
            <div class="flex h-full items-center justify-center">
                <h1 class="text-4xl font-bold text-white">Contact Us</h1>
            </div>
        </background>

        <div class="container mx-auto px-4 py-12">
            <contact-form />
        </div>
    </app-layout>
</template>
