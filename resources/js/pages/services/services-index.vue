<script setup lang="ts">
import Background from '@/components/background/background.vue';
import ServiceBannerContainer from '@/components/services/service-banner-container.vue';
import ServicesWidget from '@/components/services/services-widget.vue';
import AppLayout from '@/layouts/app-layout.vue';
</script>

<template>
    <app-layout>
        <background imageUrl="/images/services-background.jpg">
            <services-widget />
        </background>

        <div class="container mx-auto px-4 py-12">
            <div class="mx-auto max-w-4xl space-y-8">
                <service-banner-container />
            </div>
        </div>
    </app-layout>
</template>
