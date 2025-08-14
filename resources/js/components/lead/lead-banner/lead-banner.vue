<script setup lang="ts">
import { Building, Calendar, FileText, Globe, Mail, Phone } from 'lucide-vue-next';
import type { LeadBannerProps as Props } from './lead-banner';

const { lead } = withDefaults(defineProps<Props>(), {
    showStatus: true,
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const getStatusClasses = (status: string) => {
    switch (status) {
        case 'new':
            return 'bg-blue-100 text-blue-800';
        case 'contacted':
            return 'bg-yellow-100 text-yellow-800';
        case 'qualified':
            return 'bg-green-100 text-green-800';
        case 'proposal':
            return 'bg-purple-100 text-purple-800';
        case 'won':
            return 'bg-emerald-100 text-emerald-800';
        case 'lost':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const getStatusLabel = (status: string) => {
    return status.charAt(0).toUpperCase() + status.slice(1);
};

const getSourceLabel = (source: string) => {
    switch (source) {
        case 'website':
            return 'Website';
        case 'referral':
            return 'Referral';
        case 'social_media':
            return 'Social Media';
        case 'advertising':
            return 'Advertising';
        case 'other':
            return 'Other';
        default:
            return source;
    }
};

const getSourceIcon = (source: string) => {
    switch (source) {
        case 'website':
            return Globe;
        case 'referral':
            return Phone;
        case 'social_media':
            return Mail;
        case 'advertising':
            return FileText;
        default:
            return FileText;
    }
};
</script>

<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-md transition-all duration-300 hover:border-blue-300 hover:shadow-lg">
        <div class="mb-4 flex items-start justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ lead.name }}</h3>
                <p v-if="lead.company" class="flex items-center text-sm text-gray-600">
                    <Building class="mr-1 h-3 w-3" />
                    {{ lead.company }}
                </p>
            </div>
            <div v-if="showStatus" :class="['rounded-full px-2 py-1 text-xs', getStatusClasses(lead.status)]">
                {{ getStatusLabel(lead.status) }}
            </div>
        </div>

        <div v-if="lead.notes" class="mb-4">
            <p class="text-gray-700">{{ lead.notes.length > 150 ? lead.notes.substring(0, 150) + '...' : lead.notes }}</p>
        </div>

        <div class="grid grid-cols-2 gap-2 text-sm text-gray-500">
            <div v-if="lead.email" class="flex items-center">
                <Mail class="mr-1 h-4 w-4" />
                {{ lead.email }}
            </div>
            <div v-if="lead.phone_number" class="flex items-center">
                <Phone class="mr-1 h-4 w-4" />
                {{ lead.phone_number }}
            </div>
            <div v-if="lead.source" class="flex items-center">
                <component :is="getSourceIcon(lead.source)" class="mr-1 h-4 w-4" />
                {{ getSourceLabel(lead.source) }}
            </div>
            <div class="flex items-center">
                <Calendar class="mr-1 h-4 w-4" />
                {{ formatDate(lead.created_at) }}
            </div>
        </div>
    </div>
</template>
