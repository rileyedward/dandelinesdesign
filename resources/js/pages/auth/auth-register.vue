<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AuthLayout from '@/layouts/auth/auth-layout.vue';
import RegisterForm from '@/components/auth/register-form.vue';

interface Props {
  errors?: Record<string, string>;
}

withDefaults(defineProps<Props>(), {
  errors: () => ({})
});
</script>

<template>
  <Head title="Create Account" />

  <AuthLayout>
    <register-form :errors="errors" />
  </AuthLayout>
</template>
