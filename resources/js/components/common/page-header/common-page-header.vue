<script setup lang="ts">
import { computed } from 'vue';
import type { CommonPageHeaderProps as Props } from './common-page-header';

const props = withDefaults(defineProps<Props>(), {
    variant: 'primary',
});

const iconClasses = computed<string>(() => {
    const classes: string[] = ['flex h-12 w-12 items-center justify-center rounded-lg'];

    switch (props.variant) {
        case 'primary':
            classes.push('bg-purple-500');
            break;
        case 'secondary':
            classes.push('bg-gray-500');
            break;
        case 'success':
            classes.push('bg-green-500');
            break;
        case 'danger':
            classes.push('bg-red-500');
            break;
        case 'warning':
            classes.push('bg-yellow-500');
            break;
        case 'info':
            classes.push('bg-blue-500');
            break;
    }

    return classes.join(' ');
});
</script>

<template>
    <div class="border-b border-gray-200 pb-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div v-if="icon" :class="iconClasses">
                    <component :is="icon" class="h-6 w-6 text-white" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ title }}</h1>
                    <p v-if="subtitle" class="text-sm text-gray-600">{{ subtitle }}</p>
                </div>
            </div>

            <div v-if="$slots.actions" class="flex items-center space-x-2">
                <slot name="actions" />
            </div>
        </div>
    </div>
</template>
