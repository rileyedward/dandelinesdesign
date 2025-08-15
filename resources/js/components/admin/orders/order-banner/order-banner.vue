<script setup lang="ts">
import { ShoppingCart, Package } from 'lucide-vue-next';

interface Tab {
    key: string;
    label: string;
    count: number;
}

interface Props {
    tabs: Tab[];
    activeTab: string;
}

interface Emits {
    'tab-change': [tab: string];
}

defineProps<Props>();
const emit = defineEmits<Emits>();

const handleTabClick = (tab: string) => {
    emit('tab-change', tab);
};

const getTabVariant = (tabKey: string, activeTab: string) => {
    return tabKey === activeTab ? 'primary' : 'outline';
};
</script>

<template>
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="border-b border-gray-200 pb-5 pt-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-100">
                            <ShoppingCart class="h-6 w-6 text-primary-600" />
                        </div>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                            Order Management
                        </h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage and track customer orders
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mt-4">
                <nav class="-mb-px flex space-x-8">
                    <button
                        v-for="tab in tabs"
                        :key="tab.key"
                        @click="handleTabClick(tab.key)"
                        :class="[
                            'flex items-center space-x-2 border-b-2 px-1 py-4 text-sm font-medium',
                            tab.key === activeTab
                                ? 'border-primary-500 text-primary-600'
                                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'
                        ]"
                    >
                        <Package class="h-4 w-4" />
                        <span>{{ tab.label }}</span>
                        <span :class="[
                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                            tab.key === activeTab 
                                ? 'bg-primary-100 text-primary-800' 
                                : 'bg-gray-100 text-gray-800'
                        ]">
                            {{ tab.count }}
                        </span>
                    </button>
                </nav>
            </div>
        </div>
    </div>
</template>
