<script setup lang="ts">
import CommonPageHeader from '@/components/common/page-header/common-page-header.vue';
import UiCard from '@/components/ui/layout/card/ui-card.vue';
import SidebarLayout from '@/layouts/sidebar/sidebar-layout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { FileText, Home, Image, Mail, MessageSquare, Newspaper, Package, ShoppingBag, Star, Tag, UserCheck, Users } from 'lucide-vue-next';

defineProps<{
    metrics: {
        newLeads: number;
        pendingQuotes: number;
        unreadMessages: number;
        totalProducts: number;
        totalSubscribers: number;
        totalTestimonials: number;
        totalImages: number;
    };
}>();
</script>

<template>
    <Head title="Admin Dashboard" />

    <sidebar-layout>
        <div class="space-y-8">
            <common-page-header title="Admin Dashboard" subtitle="Welcome back to your business overview" :icon="Home" variant="primary" />

            <!-- Key Metrics Section -->
            <section>
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Key Metrics</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <ui-card class="border-0 bg-gradient-to-br from-purple-50 to-indigo-50">
                        <div class="flex items-center justify-between p-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">New Leads</p>
                                <p class="text-2xl font-bold text-gray-900">{{ metrics.newLeads }}</p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100">
                                <UserCheck class="h-6 w-6 text-purple-600" />
                            </div>
                        </div>
                    </ui-card>

                    <ui-card class="border-0 bg-gradient-to-br from-blue-50 to-cyan-50">
                        <div class="flex items-center justify-between p-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Pending Quotes</p>
                                <p class="text-2xl font-bold text-gray-900">{{ metrics.pendingQuotes }}</p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                                <MessageSquare class="h-6 w-6 text-blue-600" />
                            </div>
                        </div>
                    </ui-card>

                    <ui-card class="border-0 bg-gradient-to-br from-green-50 to-emerald-50">
                        <div class="flex items-center justify-between p-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Unread Messages</p>
                                <p class="text-2xl font-bold text-gray-900">{{ metrics.unreadMessages }}</p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                <Mail class="h-6 w-6 text-green-600" />
                            </div>
                        </div>
                    </ui-card>
                </div>
            </section>

            <!-- Main Navigation Sections -->
            <section>
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Quick Access</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Content Management Section -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <FileText class="h-5 w-5 text-gray-700" />
                            <h3 class="text-lg font-medium text-gray-900">Content Management</h3>
                        </div>

                        <Link href="/admin/blog">
                            <ui-card hover clickable shadow="md" class="border-l-4 border-l-blue-500 p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
                                        <FileText class="h-5 w-5 text-blue-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Blog Posts</h4>
                                        <p class="text-sm text-gray-600">Manage your blog content</p>
                                    </div>
                                </div>
                            </ui-card>
                        </Link>

                        <Link href="/admin/testimonials">
                            <ui-card hover clickable shadow="md" class="border-l-4 border-l-yellow-500 p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100">
                                        <Star class="h-5 w-5 text-yellow-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Testimonials</h4>
                                        <p class="text-sm text-gray-600">Manage customer testimonials</p>
                                    </div>
                                </div>
                            </ui-card>
                        </Link>

                        <Link href="/admin/images">
                            <ui-card hover clickable shadow="md" class="border-l-4 border-l-indigo-500 p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100">
                                        <Image class="h-5 w-5 text-indigo-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Images</h4>
                                        <p class="text-sm text-gray-600">Manage your image library</p>
                                    </div>
                                </div>
                            </ui-card>
                        </Link>
                    </div>

                    <!-- Customer Relations Section -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <Users class="h-5 w-5 text-gray-700" />
                            <h3 class="text-lg font-medium text-gray-900">Customer Relations</h3>
                        </div>

                        <Link href="/admin/leads">
                            <ui-card hover clickable shadow="md" class="border-l-4 border-l-purple-500 p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100">
                                        <UserCheck class="h-5 w-5 text-purple-600" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-medium text-gray-900">Leads</h4>
                                            <span class="rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800"
                                                >{{ metrics.newLeads }} new</span
                                            >
                                        </div>
                                        <p class="text-sm text-gray-600">Track and manage potential customers</p>
                                    </div>
                                </div>
                            </ui-card>
                        </Link>

                        <Link href="/admin/messages">
                            <ui-card hover clickable shadow="md" class="border-l-4 border-l-cyan-500 p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-cyan-100">
                                        <Mail class="h-5 w-5 text-cyan-600" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-medium text-gray-900">Messages</h4>
                                            <span class="rounded-full bg-cyan-100 px-2 py-0.5 text-xs font-medium text-cyan-800"
                                                >{{ metrics.unreadMessages }} unread</span
                                            >
                                        </div>
                                        <p class="text-sm text-gray-600">View and respond to customer inquiries</p>
                                    </div>
                                </div>
                            </ui-card>
                        </Link>

                        <Link href="/admin/quotes">
                            <ui-card hover clickable shadow="md" class="border-l-4 border-l-blue-500 p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
                                        <MessageSquare class="h-5 w-5 text-blue-600" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-medium text-gray-900">Quote Requests</h4>
                                            <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800"
                                                >{{ metrics.pendingQuotes }} pending</span
                                            >
                                        </div>
                                        <p class="text-sm text-gray-600">Manage customer quote requests</p>
                                    </div>
                                </div>
                            </ui-card>
                        </Link>
                    </div>

                    <!-- Combined Ecommerce & Newsletter Section -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <ShoppingBag class="h-5 w-5 text-gray-700" />
                            <h3 class="text-lg font-medium text-gray-900">Ecommerce</h3>
                        </div>

                        <Link href="/admin/products">
                            <ui-card hover clickable shadow="md" class="border-l-4 border-l-teal-500 p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-teal-100">
                                        <Package class="h-5 w-5 text-teal-600" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-medium text-gray-900">Products</h4>
                                            <span class="rounded-full bg-teal-100 px-2 py-0.5 text-xs font-medium text-teal-800"
                                                >{{ metrics.totalProducts }} total</span
                                            >
                                        </div>
                                        <p class="text-sm text-gray-600">Manage your product catalog</p>
                                    </div>
                                </div>
                            </ui-card>
                        </Link>

                        <Link href="/admin/categories">
                            <ui-card hover clickable shadow="md" class="border-l-4 border-l-pink-500 p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-pink-100">
                                        <Tag class="h-5 w-5 text-pink-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Categories</h4>
                                        <p class="text-sm text-gray-600">Manage product categories</p>
                                    </div>
                                </div>
                            </ui-card>
                        </Link>

                        <div class="mt-6 flex items-center space-x-2">
                            <Newspaper class="h-5 w-5 text-gray-700" />
                            <h3 class="text-lg font-medium text-gray-900">Newsletter</h3>
                        </div>

                        <Link href="/admin/newsletter/subscribers">
                            <ui-card hover clickable shadow="md" class="border-l-4 border-l-green-500 p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
                                        <Users class="h-5 w-5 text-green-600" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-medium text-gray-900">Subscribers</h4>
                                            <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800"
                                                >{{ metrics.totalSubscribers }} total</span
                                            >
                                        </div>
                                        <p class="text-sm text-gray-600">Manage newsletter subscribers</p>
                                    </div>
                                </div>
                            </ui-card>
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    </sidebar-layout>
</template>
