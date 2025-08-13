import { useLocalStorage } from '@vueuse/core';
import { computed, ref } from 'vue';

interface SidebarState {
    isOpen: boolean;
    expandedItems: Record<string, boolean>;
    isMobileMenuOpen: boolean;
}

export function useSidebarState() {
    const isOpen = useLocalStorage('sidebar-is-open', true);

    const expandedItems = useLocalStorage<Record<string, boolean>>('sidebar-expanded-items', {});

    const isMobileMenuOpen = ref(false);

    const toggleSidebar = () => {
        isOpen.value = !isOpen.value;
    };

    const toggleMenuItem = (itemKey: string) => {
        expandedItems.value[itemKey] = !expandedItems.value[itemKey];
    };

    const toggleMobileMenu = () => {
        isMobileMenuOpen.value = !isMobileMenuOpen.value;
    };

    const closeMobileMenu = () => {
        isMobileMenuOpen.value = false;
    };

    const sidebarState = computed<SidebarState>(() => ({
        isOpen: isOpen.value,
        expandedItems: expandedItems.value,
        isMobileMenuOpen: isMobileMenuOpen.value,
    }));

    return {
        isOpen,
        expandedItems,
        isMobileMenuOpen,
        sidebarState,
        toggleSidebar,
        toggleMenuItem,
        toggleMobileMenu,
        closeMobileMenu,
    };
}
