<script setup lang="ts">
import { Calendar, DollarSign, Mail, MapPin, Phone, Users } from 'lucide-vue-next';
import type { QuoteRequestBannerProps as Props } from './quote-request-banner';

const { request } = withDefaults(defineProps<Props>(), {
    showStatus: true,
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(amount);
};

const getServiceTypeLabel = (type: string) => {
    switch (type) {
        case 'floral_design':
            return 'Floral Design';
        case 'event_planning':
            return 'Event Planning';
        case 'both':
            return 'Floral Design & Event Planning';
        default:
            return type;
    }
};

const getStatusClasses = (status: string) => {
    switch (status) {
        case 'pending':
            return 'bg-yellow-100 text-yellow-800';
        case 'contacted':
            return 'bg-blue-100 text-blue-800';
        case 'quoted':
            return 'bg-green-100 text-green-800';
        case 'completed':
            return 'bg-purple-100 text-purple-800';
        case 'cancelled':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const getStatusLabel = (status: string) => {
    return status.charAt(0).toUpperCase() + status.slice(1);
};
</script>

<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-md transition-all duration-300 hover:border-blue-300 hover:shadow-lg">
        <div class="mb-4 flex items-start justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ request.name }}</h3>
                <p class="text-sm text-gray-600">{{ getServiceTypeLabel(request.service_type) }}</p>
            </div>
            <div v-if="showStatus" :class="['rounded-full px-2 py-1 text-xs', getStatusClasses(request.status)]">
                {{ getStatusLabel(request.status) }}
            </div>
        </div>

        <div class="mb-4">
            <p class="text-gray-700">{{ request.description.length > 150 ? request.description.substring(0, 150) + '...' : request.description }}</p>
        </div>

        <div class="grid grid-cols-2 gap-2 text-sm text-gray-500">
            <div class="flex items-center">
                <Mail class="mr-1 h-4 w-4" />
                {{ request.email }}
            </div>
            <div v-if="request.phone_number" class="flex items-center">
                <Phone class="mr-1 h-4 w-4" />
                {{ request.phone_number }}
            </div>
            <div v-if="request.event_date" class="flex items-center">
                <Calendar class="mr-1 h-4 w-4" />
                {{ formatDate(request.event_date) }}
            </div>
            <div v-if="request.budget" class="flex items-center">
                <DollarSign class="mr-1 h-4 w-4" />
                {{ formatCurrency(request.budget) }}
            </div>
            <div v-if="request.guest_count" class="flex items-center">
                <Users class="mr-1 h-4 w-4" />
                {{ request.guest_count }} guests
            </div>
            <div v-if="request.event_location" class="flex items-center">
                <MapPin class="mr-1 h-4 w-4" />
                {{ request.event_location }}
            </div>
        </div>
    </div>
</template>
