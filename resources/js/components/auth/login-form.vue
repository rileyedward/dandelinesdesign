<script setup lang="ts">
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiCheckbox from '@/components/ui/forms/checkbox/ui-checkbox.vue';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { Lock, Mail } from 'lucide-vue-next';
import { onMounted } from 'vue';

const page = usePage();
const isLocalDevelopment = page.props?.env === 'local';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

onMounted(() => {
    if (isLocalDevelopment) {
        form.email = 'admin@dandelinesdesign.com';
        form.password = 'password';
    }
});

const handleSubmit = () => {
    form.post(route('auth.login.store'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="space-y-6">
        <div class="text-center">
            <h3 class="text-2xl font-semibold text-gray-900">Welcome back</h3>
            <p class="mt-2 text-sm text-gray-600">Sign in to your account</p>
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-4">
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
                placeholder="Enter your password"
                :prefix-icon="Lock"
                :error-text="form.errors.password"
                :disabled="form.processing"
                required
                full-width
            />

            <div class="flex items-center justify-between">
                <ui-checkbox v-model="form.remember" label="Remember me" :disabled="form.processing" />
            </div>

            <ui-button label="Sign in" type="submit" variant="primary" size="lg" :loading="form.processing" :disabled="form.processing" full-width />
        </form>
    </div>
</template>
