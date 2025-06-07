<script setup lang="ts">
import Modal from '@/components/modal/modal.vue';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { route } from 'ziggy-js';

const props = defineProps<{
    isOpen: boolean;
    onClose: () => void;
}>();

const form = reactive({
    username: '',
    password: '',
    remember: false,
});

const errors = reactive<Record<string, string>>({});

const resetForm = () => {
    form.username = '';
    form.password = '';
    form.remember = false;

    Object.keys(errors).forEach((key) => {
        delete errors[key];
    });
};

const submitForm = () => {
    router.post(route('login'), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            resetForm();
            props.onClose();
        },
        onError: (err) => {
            Object.keys(err).forEach((key) => {
                errors[key] = err[key];
            });
        },
    });
};
</script>

<template>
    <modal :is-open="isOpen" :on-close="onClose" size="sm">
        <div class="text-center">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Admin Login</h3>
        </div>
        <form @submit.prevent="submitForm">
            <div class="mb-6">
                <label for="username" class="mb-2 block text-sm font-medium">Username</label>
                <input
                    id="username"
                    v-model="form.username"
                    type="text"
                    class="focus:ring-primary w-full rounded-md border px-4 py-3 focus:ring-2 focus:outline-none"
                />
                <p v-if="errors.username" class="mt-1 text-sm text-red-600">{{ errors.username }}</p>
            </div>

            <div class="mb-6">
                <label for="password" class="mb-2 block text-sm font-medium">Password</label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="focus:ring-primary w-full rounded-md border px-4 py-3 focus:ring-2 focus:outline-none"
                />
                <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</p>
            </div>

            <div class="mb-6 flex items-center">
                <input
                    id="remember"
                    v-model="form.remember"
                    type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="rounded-md border border-gray-300 bg-white px-6 py-3 text-black hover:bg-gray-100 focus:ring-2 focus:ring-white focus:outline-none"
                >
                    Login
                </button>
            </div>
        </form>
    </modal>
</template>
