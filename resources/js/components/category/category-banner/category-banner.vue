<script setup lang="ts">
import { Calendar, CheckCircle, Hash, XCircle } from 'lucide-vue-next';
import type { CategoryBannerProps as Props } from './category-banner';

const { category } = withDefaults(defineProps<Props>(), {
    showStatus: true,
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const truncateDescription = (description: string, maxLength: number = 150) => {
    if (!description) return 'No description';
    if (description.length <= maxLength) return description;
    return description.substring(0, maxLength) + '...';
};
</script>

<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-md transition-all duration-300 hover:border-blue-300 hover:shadow-lg">
        <div class="mb-4 flex items-start justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ category.name }}</h3>
                <p class="text-sm text-gray-600">{{ category.slug }}</p>
            </div>
            <div v-if="showStatus" :class="['rounded-full px-2 py-1 text-xs', category.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800']">
                <CheckCircle v-if="category.is_active" class="mr-1 inline-block h-3 w-3" />
                <XCircle v-else class="mr-1 inline-block h-3 w-3" />
                {{ category.is_active ? 'Active' : 'Inactive' }}
            </div>
        </div>

        <div class="mb-4">
            <p class="text-gray-700">{{ truncateDescription(category.description) }}</p>
        </div>

        <div class="grid grid-cols-2 gap-2 text-sm text-gray-500">
            <div class="flex items-center">
                <Hash class="mr-1 h-4 w-4" />
                Sort Order: {{ category.sort_order }}
            </div>
            <div class="flex items-center">
                <Calendar class="mr-1 h-4 w-4" />
                {{ formatDate(category.created_at) }}
            </div>
        </div>
    </div>
</template>
