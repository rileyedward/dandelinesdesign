<script setup lang="ts">
import UiFooter from '@/components/ui/footer/ui-footer.vue';
import UiNavbar from '@/components/ui/navigation/navbar/ui-navbar.vue';
import { Head as InertiaHead } from '@inertiajs/vue3';
import defaultConfig from './navbar-layout.config';

interface Props {
    pageTitle?: string;
}

const props = withDefaults(defineProps<Props>(), {
    pageTitle: 'Dandelines Design',
});
</script>

<template>
    <inertia-head :title="props.pageTitle" />

    <ui-navbar :left-nav-links="defaultConfig.leftNavLinks" :right-nav-links="defaultConfig.rightNavLinks" />

    <main>
        <slot />
    </main>

    <ui-footer :contact-info="defaultConfig.contactInfo" :navigation-links="defaultConfig.navigationLinks" :social-links="defaultConfig.socialLinks" />
</template>
