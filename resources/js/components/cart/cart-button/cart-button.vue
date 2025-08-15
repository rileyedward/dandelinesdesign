<script setup lang="ts">
import { useCart } from '@/composables/useCart';
import { ShoppingCartIcon } from 'lucide-vue-next';

interface Emits {
    click: [];
}

const emit = defineEmits<Emits>();

const { cart, hasItems } = useCart();

const handleClick = () => {
    emit('click');
};
</script>

<template>
    <Transition
        enter-active-class="transition-all duration-300 ease-out"
        enter-from-class="transform translate-y-full opacity-0"
        enter-to-class="transform translate-y-0 opacity-100"
        leave-active-class="transition-all duration-200 ease-in"
        leave-from-class="transform translate-y-0 opacity-100"
        leave-to-class="transform translate-y-full opacity-0"
    >
        <button
            v-if="hasItems"
            @click="handleClick"
            class="fixed right-6 bottom-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-white shadow-lg transition-all duration-200 hover:scale-110 hover:bg-blue-700 focus:ring-4 focus:ring-blue-600/25 focus:outline-none"
        >
            <div class="relative">
                <ShoppingCartIcon class="h-6 w-6" />

                <div class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">
                    {{ cart.totalItems > 99 ? '99+' : cart.totalItems }}
                </div>
            </div>
        </button>
    </Transition>
</template>
