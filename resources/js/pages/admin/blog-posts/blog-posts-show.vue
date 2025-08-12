<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import type { BlogPost } from '@/types/blog';
import { FileText, Calendar, Eye } from 'lucide-vue-next';

defineProps<{
  blogPost: BlogPost;
}>();
</script>

<template>
  <Head :title="blogPost.title" />
  
  <sidebar-layout>
    <div class="space-y-6">
      <common-page-header
        :title="blogPost.title"
        subtitle="Blog post details"
        :icon="FileText"
        variant="primary"
      />

      <!-- Blog Post Content -->
      <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="space-y-6">
          <!-- Meta Information -->
          <div class="flex items-center space-x-6 text-sm text-gray-500 border-b pb-4">
            <div class="flex items-center">
              <Calendar class="h-4 w-4 mr-1" />
              Created: {{ new Date(blogPost.created_at).toLocaleDateString() }}
            </div>
            <div class="flex items-center">
              <Eye class="h-4 w-4 mr-1" />
              Status: 
              <span :class="blogPost.is_published ? 'text-green-600 ml-1' : 'text-yellow-600 ml-1'">
                {{ blogPost.is_published ? 'Published' : 'Draft' }}
              </span>
            </div>
          </div>

          <!-- Slug -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ blogPost.slug }}</code>
          </div>

          <!-- Content -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
            <div class="prose max-w-none bg-gray-50 p-4 rounded-lg">
              {{ blogPost.content }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </sidebar-layout>
</template>
