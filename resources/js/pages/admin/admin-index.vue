<script setup lang="ts">
import AdminLayout from '@/layouts/admin-layout.vue';
import { FileText, MessageSquare, ShoppingBag, Quote, Star } from 'lucide-vue-next';
</script>

<template>
    <admin-layout page-title="Dashboard" page-description="Welcome to the Dandelines Design admin panel.">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <a href="/admin/blog-posts" class="rounded-lg bg-white p-6 shadow-md transition-all hover:shadow-lg">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                    <FileText class="h-6 w-6" />
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Blog Posts</h2>
                <p class="mt-2 text-gray-600">Manage your blog content</p>
            </a>

            <a href="/admin/contact-messages" class="rounded-lg bg-white p-6 shadow-md transition-all hover:shadow-lg">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600">
                    <MessageSquare class="h-6 w-6" />
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Contact Messages</h2>
                <p class="mt-2 text-gray-600">View and respond to messages</p>
            </a>

            <a href="/admin/products" class="rounded-lg bg-white p-6 shadow-md transition-all hover:shadow-lg">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 text-purple-600">
                    <ShoppingBag class="h-6 w-6" />
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Products</h2>
                <p class="mt-2 text-gray-600">Manage your store products</p>
            </a>

            <a href="/admin/quotes" class="rounded-lg bg-white p-6 shadow-md transition-all hover:shadow-lg">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                    <Quote class="h-6 w-6" />
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Quotes</h2>
                <p class="mt-2 text-gray-600">Manage customer quotes</p>
            </a>

            <a href="/admin/testimonials" class="rounded-lg bg-white p-6 shadow-md transition-all hover:shadow-lg">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-pink-100 text-pink-600">
                    <Star class="h-6 w-6" />
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Testimonials</h2>
                <p class="mt-2 text-gray-600">Manage customer testimonials</p>
            </a>
        </div>
    </admin-layout>
</template>
