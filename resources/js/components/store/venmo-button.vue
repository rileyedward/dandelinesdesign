<script setup lang="ts">
import { VenmoButtonProps as Props } from '@/types/components/venmo-button';
import { computed } from 'vue';

const props = defineProps<Props>();

const venmoLink = computed(() => {
    let link = `venmo://paycharge?txn=pay&recipients=${props.username}`;

    if (props.amount) {
        link += `&amount=${props.amount}`;
    }

    if (props.productName) {
        link += `&note=Purchase: ${encodeURIComponent(props.productName)}`;
    }

    return link;
});

const fallbackLink = computed(() => {
    return `https://venmo.com/${props.username}`;
});

const openVenmo = () => {
    window.location.href = venmoLink.value;

    setTimeout(() => {
        window.location.href = fallbackLink.value;
    }, 500);
};
</script>

<template>
    <button
        @click="openVenmo"
        class="flex items-center justify-center rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
    >
        <span class="mr-2">Pay with</span>
        <span class="font-bold">Venmo</span>
    </button>
</template>
