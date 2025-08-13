<script setup lang="ts">
import { BackgroundProps as Props } from '@/components/common/common-background/common-background';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = withDefaults(defineProps<Props>(), {
    imageUrl: '/images/placeholder.jpg',
    height: '80vh',
    overlayColor: 'rgba(0, 0, 0, 0.4)',
    overlayOpacity: 0.4,
    enableParallax: true,
    gradientOverlay: false,
    gradientDirection: 'to-b',
    gradientFromColor: 'rgba(0, 0, 0, 0.6)',
    gradientToColor: 'rgba(0, 0, 0, 0.2)',
});

const parallaxOffset = ref(0);
const backgroundRef = ref<HTMLElement | null>(null);

const overlayStyle = computed(() => {
    if (props.gradientOverlay) {
        return {
            background: `linear-gradient(${props.gradientDirection}, ${props.gradientFromColor}, ${props.gradientToColor})`,
        };
    }

    return {
        backgroundColor: props.overlayColor,
        opacity: props.overlayOpacity,
    };
});

const backgroundStyle = computed(() => {
    const style: Record<string, string> = {
        backgroundImage: `url(${props.imageUrl})`,
        height: props.height,
        zIndex: '0',
    };

    if (props.enableParallax) {
        style.backgroundAttachment = 'fixed';
        style.backgroundPosition = `center ${50 + parallaxOffset.value * 0.05}%`;
    }

    return style;
});

const handleScroll = () => {
    if (!props.enableParallax || !backgroundRef.value) return;

    const rect = backgroundRef.value.getBoundingClientRect();
    const viewportHeight = window.innerHeight;
    const elementCenter = rect.top + rect.height / 2;
    const viewportCenter = viewportHeight / 2;

    // Calculate how far the element is from the center of the viewport
    parallaxOffset.value = (elementCenter - viewportCenter) * 0.1;
};

onMounted(() => {
    if (props.enableParallax) {
        window.addEventListener('scroll', handleScroll);
        handleScroll();
    }
});

onUnmounted(() => {
    if (props.enableParallax) {
        window.removeEventListener('scroll', handleScroll);
    }
});
</script>

<template>
    <div
        ref="backgroundRef"
        class="relative w-full bg-cover bg-center bg-no-repeat object-cover object-center overflow-hidden"
        :style="backgroundStyle"
    >
        <!-- Overlay -->
        <div
            class="absolute inset-0 transition-opacity duration-700"
            :style="overlayStyle"
        />

        <!-- Content -->
        <div class="relative z-10 container mx-auto h-full px-4">
            <slot />
        </div>
    </div>
</template>
