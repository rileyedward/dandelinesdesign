<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AuthLayout from '@/layouts/auth/auth-layout.vue';
import LoginForm from '@/components/auth/login-form.vue';

interface Props {
  errors?: Record<string, string>;
}

withDefaults(defineProps<Props>(), {
  errors: () => ({})
});
</script>

<template>
  <Head title="Sign In" />

  <AuthLayout>
    <login-form :errors="errors" />
  </AuthLayout>
</template>
