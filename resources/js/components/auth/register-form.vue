<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Lock, Mail, User } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const handleSubmit = () => {
    form.post(route('auth.register.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="space-y-6">
        <div class="text-center">
            <h3 class="text-2xl font-semibold text-gray-900">Create your account</h3>
            <p class="mt-2 text-sm text-gray-600">Join us and start your floral design journey</p>
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-4">
            <ui-input
                v-model="form.name"
                type="text"
                label="Full name"
                placeholder="Enter your full name"
                :prefix-icon="User"
                :error-text="form.errors.name"
                :disabled="form.processing"
                required
                full-width
            />

            <ui-input
                v-model="form.email"
                type="email"
                label="Email address"
                placeholder="Enter your email"
                :prefix-icon="Mail"
                :error-text="form.errors.email"
                :disabled="form.processing"
                required
                full-width
            />

            <ui-input
                v-model="form.password"
                type="password"
                label="Password"
                placeholder="Create a password"
                :prefix-icon="Lock"
                :error-text="form.errors.password"
                :disabled="form.processing"
                required
                full-width
            />

            <ui-input
                v-model="form.password_confirmation"
                type="password"
                label="Confirm password"
                placeholder="Confirm your password"
                :prefix-icon="Lock"
                :error-text="form.errors.password_confirmation"
                :disabled="form.processing"
                required
                full-width
            />

            <ui-button
                label="Create account"
                type="submit"
                variant="primary"
                size="lg"
                :loading="form.processing"
                :disabled="form.processing"
                full-width
            />
        </form>

        <div class="text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <Link :href="route('auth.login.index')" class="font-medium text-purple-600 transition-colors hover:text-purple-500"> Sign in </Link>
            </p>
        </div>
    </div>
</template>
