<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import { Construction, FileText } from 'lucide-vue-next';
</script>

<template>
  <Head title="Blog Post Details" />
  
  <sidebar-layout>
    <div class="space-y-6">
      <common-page-header
        title="Blog Post Details"
        subtitle="View blog post information"
        :icon="FileText"
        variant="primary"
      />

      <!-- Under Construction Content -->
      <div class="flex flex-col items-center justify-center py-20">
        <div class="text-center">
          <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-yellow-100">
            <Construction class="h-10 w-10 text-yellow-600" />
          </div>

          <h2 class="mt-6 text-xl font-semibold text-gray-900">Page Under Construction</h2>

          <p class="mt-2 max-w-md text-sm text-gray-600">This page is being developed. Blog post details will be available soon.</p>
        </div>
      </div>
    </div>
  </sidebar-layout>
</template>
