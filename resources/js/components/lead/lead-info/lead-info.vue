<script setup lang="ts">
import LeadUpdateDrawer from '@/components/lead/lead-update-drawer/lead-update-drawer.vue';
import { Building, Calendar, Edit, Mail, Phone, User } from 'lucide-vue-next';
import { ref } from 'vue';
import type { LeadInfoProps as Props } from './lead-info';

const { lead } = withDefaults(defineProps<Props>(), {
    showEditButton: true,
});

const emit = defineEmits<{
    (e: 'updated'): void;
}>();

const showUpdateDrawer = ref(false);

const handleEditClick = () => {
    showUpdateDrawer.value = true;
};

const handleLeadUpdated = () => {
    emit('updated');
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const getStatusColor = (status: string) => {
    const colors = {
        new: 'bg-blue-100 text-blue-800',
        contacted: 'bg-yellow-100 text-yellow-800',
        qualified: 'bg-purple-100 text-purple-800',
        proposal: 'bg-orange-100 text-orange-800',
        won: 'bg-green-100 text-green-800',
        lost: 'bg-red-100 text-red-800',
    };
    return colors[status as keyof typeof colors] || 'bg-gray-100 text-gray-800';
};

const getSourceDisplay = (source: string) => {
    const sources = {
        website: 'Website',
        referral: 'Referral',
        social_media: 'Social Media',
        advertising: 'Advertising',
        other: 'Other',
    };
    return sources[source as keyof typeof sources] || source;
};

const formatStatus = (status: string) => {
    return status.charAt(0).toUpperCase() + status.slice(1);
};
</script>

<template>
    <div class="rounded-lg border border-gray-200 bg-white shadow-md transition-all duration-300 hover:border-blue-300 hover:shadow-lg">
        <!-- Header Section -->
        <div class="border-b border-gray-200 p-6">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-xl font-semibold text-gray-900">{{ lead.name }}</h2>
                        <div
                            :class="['rounded-full px-3 py-1 text-xs font-medium', getStatusColor(lead.status)]"
                        >
                            {{ formatStatus(lead.status) }}
                        </div>
                    </div>
                    <p v-if="lead.company" class="flex items-center text-sm text-gray-600">
                        <Building class="mr-2 h-4 w-4" />
                        {{ lead.company }}
                    </p>
                </div>
                <button
                    v-if="showEditButton"
                    class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600"
                    aria-label="Edit lead"
                    @click="handleEditClick"
                >
                    <Edit class="h-5 w-5" />
                </button>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="p-6">
            <h3 class="mb-4 text-sm font-medium text-gray-900 uppercase tracking-wide">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <Mail class="mr-3 h-4 w-4 text-gray-400" />
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ lead.email }}</p>
                        <p class="text-xs text-gray-500">Email</p>
                    </div>
                </div>
                <div v-if="lead.phone_number" class="flex items-center">
                    <Phone class="mr-3 h-4 w-4 text-gray-400" />
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ lead.phone_number }}</p>
                        <p class="text-xs text-gray-500">Phone</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lead Details -->
        <div v-if="lead.source" class="border-t border-gray-200 p-6">
            <h3 class="mb-4 text-sm font-medium text-gray-900 uppercase tracking-wide">Lead Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <User class="mr-3 h-4 w-4 text-gray-400" />
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ getSourceDisplay(lead.source) }}</p>
                        <p class="text-xs text-gray-500">Source</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <Calendar class="mr-3 h-4 w-4 text-gray-400" />
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ formatDate(lead.created_at) }}</p>
                        <p class="text-xs text-gray-500">Created</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        <div v-if="lead.notes" class="border-t border-gray-200 p-6">
            <h3 class="mb-3 text-sm font-medium text-gray-900 uppercase tracking-wide">Notes</h3>
            <div class="rounded-lg bg-gray-50 p-4">
                <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ lead.notes }}</p>
            </div>
        </div>

        <!-- Update Drawer -->
        <lead-update-drawer
            :show="showUpdateDrawer"
            :lead="lead"
            @update:show="showUpdateDrawer = $event"
            @updated="handleLeadUpdated"
        />
    </div>
</template>