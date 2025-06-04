<script setup lang="ts">
import { ModalProps as Props } from '@/types/components/modal';

const props = defineProps<Props>();

const closeModal = () => {
    props.onClose();
};
</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden">
        <div class="fixed inset-0 backdrop-blur-sm transition-opacity" @click="closeModal"></div>
        <div class="relative z-10 mx-auto w-full max-w-md p-4">
            <div class="rounded-lg bg-white p-6 shadow-xl">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <slot />
                    </div>
                    <button
                        type="button"
                        class="ml-4 inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900"
                        @click="closeModal"
                    >
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-4 flex justify-end">
                    <button
                        type="button"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        @click="closeModal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
