<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import UiInput from '@/components/ui/forms/input/ui-input.vue';
import UiButton from '@/components/ui/forms/button/ui-button.vue';
import UiCheckbox from '@/components/ui/forms/checkbox/ui-checkbox.vue';
import { Mail, Lock } from 'lucide-vue-next';
import type { LoginFormProps as Props, LoginFormEmits as Emits } from './login-form';
withDefaults(defineProps<Props>(), {
  errors: () => ({})
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
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
      <UiInput
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

      <UiInput
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
        <UiCheckbox
          v-model="form.remember"
          label="Remember me"
          :disabled="form.processing"
        />

        <a
          href="#"
          class="text-sm text-purple-600 hover:text-purple-500 transition-colors"
        >
          Forgot password?
        </a>
      </div>

      <UiButton
        type="submit"
        variant="primary"
        size="lg"
        :loading="form.processing"
        :disabled="form.processing"
        full-width
      >
        Sign in
      </UiButton>
    </form>

    <div class="text-center">
      <p class="text-sm text-gray-600">
        Don't have an account?
        <Link
          :href="route('auth.register.index')"
          class="text-purple-600 hover:text-purple-500 font-medium transition-colors"
        >
          Sign up
        </Link>
      </p>
    </div>
  </div>
</template>
