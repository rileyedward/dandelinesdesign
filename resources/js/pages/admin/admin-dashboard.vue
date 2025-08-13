<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import UiCard from '@/components/ui/layout/card/ui-card.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { FileText, Home, Mail, MessageSquare, Package, Star, Tag, UserCheck } from 'lucide-vue-next';
</script>

<template>
    <Head title="Admin Dashboard" />

    <sidebar-layout>
        <div class="space-y-6">
            <common-page-header title="Admin Dashboard" subtitle="Overview of your business" :icon="Home" variant="primary" />

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Content Management Section -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Content Management</h3>

                    <Link href="/admin/blog">
                        <ui-card hover clickable class="p-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                                    <FileText class="h-6 w-6 text-blue-600" />
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Blog Posts</h4>
                                    <p class="text-sm text-gray-600">Manage your blog content</p>
                                </div>
                            </div>
                        </ui-card>
                    </Link>

                    <Link href="/admin/messages">
                        <ui-card hover clickable class="p-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                                    <Mail class="h-6 w-6 text-indigo-600" />
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Contact Messages</h4>
                                    <p class="text-sm text-gray-600">View and respond to customer inquiries</p>
                                </div>
                            </div>
                        </ui-card>
                    </Link>
                </div>

                <!-- Customer Relations Section -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Customer Relations</h3>

                    <Link href="/admin/quotes">
                        <ui-card hover clickable class="p-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100">
                                    <MessageSquare class="h-6 w-6 text-purple-600" />
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Quote Requests</h4>
                                    <p class="text-sm text-gray-600">Manage customer quote requests</p>
                                </div>
                            </div>
                        </ui-card>
                    </Link>

                    <Link href="/admin/testimonials">
                        <ui-card hover clickable class="p-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100">
                                    <Star class="h-6 w-6 text-yellow-600" />
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Testimonials</h4>
                                    <p class="text-sm text-gray-600">Manage customer testimonials</p>
                                </div>
                            </div>
                        </ui-card>
                    </Link>

                    <Link href="/admin/leads">
                        <ui-card hover clickable class="p-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                    <UserCheck class="h-6 w-6 text-green-600" />
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Leads</h4>
                                    <p class="text-sm text-gray-600">Track and manage potential customers</p>
                                </div>
                            </div>
                        </ui-card>
                    </Link>
                </div>

                <!-- Ecommerce Section -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Ecommerce</h3>

                    <Link href="/admin/categories">
                        <ui-card hover clickable class="p-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-pink-100">
                                    <Tag class="h-6 w-6 text-pink-600" />
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Categories</h4>
                                    <p class="text-sm text-gray-600">Manage product categories</p>
                                </div>
                            </div>
                        </ui-card>
                    </Link>

                    <Link href="/admin/products">
                        <ui-card hover clickable class="p-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-teal-100">
                                    <Package class="h-6 w-6 text-teal-600" />
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Products</h4>
                                    <p class="text-sm text-gray-600">Manage your product catalog</p>
                                </div>
                            </div>
                        </ui-card>
                    </Link>
                </div>
            </div>
        </div>
    </sidebar-layout>
</template>
