<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { ChevronDown, ChevronUp, ChevronRight } from 'lucide-vue-next';
import type { UiMenuProps as Props, UiMenuEmits as Emits, MenuItem } from './ui-menu';

const props = withDefaults(defineProps<Props>(), {
  title: '',
  collapsible: false,
  defaultOpen: true,
  variant: 'vertical',
  activeItem: '',
});

const emit = defineEmits<Emits>();

const isOpen = ref(props.defaultOpen);
const activeItemValue = ref(props.activeItem);

const expandedItems = ref<Record<string, boolean>>({});

watch(
  () => props.activeItem,
  newValue => {
    activeItemValue.value = newValue;
  }
);

const toggleMenu = (): void => {
  if (props.collapsible) {
    isOpen.value = !isOpen.value;
  }
};

const toggleSubmenu = (itemValue: string): void => {
  expandedItems.value[itemValue] = !expandedItems.value[itemValue];
};

const handleSelect = (item: MenuItem): void => {
  if (!item.disabled) {
    activeItemValue.value = item.value;
    emit('select', item);
    emit('update:activeItem', item.value);
  }
};

const menuClasses = computed(() => {
  return [
    props.variant === 'vertical' ? 'flex-col' : 'flex-row',
    'flex',
    'rounded-md',
    'overflow-hidden',
  ];
});
</script>

<template>
  <div class="ui-menu w-full">
    <div
      v-if="title && collapsible"
      class="flex items-center justify-between px-4 py-2 bg-gray-100 cursor-pointer"
      @click="toggleMenu"
    >
      <h3 class="text-sm font-medium text-gray-700">{{ title }}</h3>
      <component :is="isOpen ? ChevronUp : ChevronDown" class="w-4 h-4 text-gray-500" />
    </div>

    <div v-else-if="title" class="px-4 py-2 bg-gray-100">
      <h3 class="text-sm font-medium text-gray-700">{{ title }}</h3>
    </div>

    <div v-if="!collapsible || isOpen" class="bg-white border border-gray-200 rounded-md">
      <ul :class="menuClasses">
        <li
          v-for="item in items"
          :key="item.value"
          :class="[
            'relative',
            variant === 'vertical' ? 'w-full' : '',
            item.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
            variant === 'horizontal' && item.children && item.children.length > 0 ? 'group' : '',
          ]"
        >
          <a
            :href="item.href || '#'"
            :class="[
              'flex items-center px-4 py-2 text-sm',
              'transition-colors duration-200',
              activeItemValue === item.value
                ? 'bg-purple-100 text-purple-700'
                : 'text-gray-700 hover:bg-gray-100',
            ]"
            @click.prevent="
              item.children && item.children.length > 0 && variant === 'vertical'
                ? toggleSubmenu(item.value)
                : !item.disabled && handleSelect(item)
            "
          >
            <component :is="item.icon" v-if="item.icon" class="w-4 h-4 mr-2" />
            <span>{{ item.label }}</span>

            <component
              :is="expandedItems[item.value] ? ChevronUp : ChevronDown"
              v-if="item.children && item.children.length > 0 && variant === 'vertical'"
              class="w-4 h-4 ml-auto"
            />

            <component
              :is="ChevronRight"
              v-if="item.children && item.children.length > 0 && variant === 'horizontal'"
              class="w-4 h-4 ml-2"
            />
          </a>

          <div
            v-if="item.children && item.children.length > 0 && variant === 'vertical'"
            :class="[
              'overflow-hidden transition-all duration-200',
              expandedItems[item.value] ? 'max-h-96' : 'max-h-0',
            ]"
          >
            <ul class="bg-gray-50">
              <li
                v-for="child in item.children"
                :key="child.value"
                :class="[
                  'relative',
                  'w-full',
                  child.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
                ]"
              >
                <a
                  :href="child.href || '#'"
                  :class="[
                    'flex items-center px-4 py-2 text-sm',
                    'transition-colors duration-200',
                    'pl-8',
                    activeItemValue === child.value
                      ? 'bg-purple-100 text-purple-700'
                      : 'text-gray-700 hover:bg-gray-100',
                  ]"
                  @click.prevent="!child.disabled && handleSelect(child)"
                >
                  <component :is="child.icon" v-if="child.icon" class="w-4 h-4 mr-2" />
                  <span>{{ child.label }}</span>
                </a>
              </li>
            </ul>
          </div>

          <ul
            v-if="item.children && item.children.length > 0 && variant === 'horizontal'"
            class="absolute left-0 top-full bg-white border border-gray-200 rounded-md shadow-lg min-w-[200px] z-10 hidden group-hover:block"
          >
            <li
              v-for="child in item.children"
              :key="child.value"
              :class="[
                'relative',
                'w-full',
                child.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
              ]"
            >
              <a
                :href="child.href || '#'"
                :class="[
                  'flex items-center px-4 py-2 text-sm',
                  'transition-colors duration-200',
                  activeItemValue === child.value
                    ? 'bg-purple-100 text-purple-700'
                    : 'text-gray-700 hover:bg-gray-100',
                ]"
                @click.prevent="!child.disabled && handleSelect(child)"
              >
                <component :is="child.icon" v-if="child.icon" class="w-4 h-4 mr-2" />
                <span>{{ child.label }}</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</template>
