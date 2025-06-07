<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminLayout from '@/layouts/admin-layout.vue';
import ContactMessageBanner from '@/components/contact/contact-message-banner.vue';
import { ContactAdminPageProps as Props } from '@/types/pages/contact';

defineProps<Props>();

const unreadMessagesExpanded = ref<boolean>(true);
const readMessagesExpanded = ref<boolean>(false);

const toggleUnreadMessages = () => {
    unreadMessagesExpanded.value = !unreadMessagesExpanded.value;
};

const toggleReadMessages = () => {
    readMessagesExpanded.value = !readMessagesExpanded.value;
};

const markAsRead = (id: number) => {
    router.delete(`/admin/contact/${id}`);
};
</script>

<template>
    <admin-layout page-title="Messages" page-description="Manage and view all contact form submissions">
        <div class="container mx-auto">
            <!-- Unread Messages Section -->
            <div class="mb-8">
                <button
                    @click="toggleUnreadMessages"
                    class="mb-4 flex w-full items-center justify-between rounded-lg bg-gray-100 px-4 py-3 text-left font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    <h2 class="text-xl font-semibold">Unread Messages <span class="ml-2 rounded-full bg-red-100 px-2.5 py-0.5 text-sm font-medium text-red-800">{{ unreadMessages.length }}</span></h2>
                    <svg
                        class="h-5 w-5 transform transition-transform duration-300"
                        :class="{ 'rotate-180': !unreadMessagesExpanded }"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div
                    v-show="unreadMessagesExpanded"
                    class="overflow-hidden transition-all duration-300 ease-in-out"
                >
                    <div v-if="unreadMessages.length === 0" class="rounded-lg bg-gray-50 p-6 text-center">
                        <p class="text-gray-600">No unread messages</p>
                    </div>
                    <div v-else>
                        <contact-message-banner
                            v-for="message in unreadMessages"
                            :key="message.id"
                            :contact-message="message"
                            :is-read="false"
                            @mark-as-read="markAsRead"
                        />
                    </div>
                </div>
            </div>

            <!-- Read Messages Section -->
            <div>
                <button
                    @click="toggleReadMessages"
                    class="mb-4 flex w-full items-center justify-between rounded-lg bg-gray-100 px-4 py-3 text-left font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    <h2 class="text-xl font-semibold">Read Messages <span class="ml-2 rounded-full bg-yellow-100 px-2.5 py-0.5 text-sm font-medium text-yellow-800">{{ readMessages.length }}</span></h2>
                    <svg
                        class="h-5 w-5 transform transition-transform duration-300"
                        :class="{ 'rotate-180': !readMessagesExpanded }"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div
                    v-show="readMessagesExpanded"
                    class="overflow-hidden transition-all duration-300 ease-in-out"
                >
                    <div v-if="readMessages.length === 0" class="rounded-lg bg-gray-50 p-6 text-center">
                        <p class="text-gray-600">No read messages</p>
                    </div>
                    <div v-else>
                        <contact-message-banner
                            v-for="message in readMessages"
                            :key="message.id"
                            :contact-message="message"
                            :is-read="true"
                        />
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>
