<script setup lang="ts">
import { services } from '@/components/services/service-banner.config';
import ServiceBanner from '@/components/services/service-banner.vue';
</script>

<template>
    <div v-for="(service, index) in services" :key="index" class="flex" :class="index % 2 === 0 ? 'justify-start' : 'justify-end'">
        <div class="w-full max-w-3xl">
            <service-banner :service="service" />
        </div>
    </div>
</template>
