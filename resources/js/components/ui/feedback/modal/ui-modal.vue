<script setup lang="ts">
import { computed, onMounted, onUnmounted, watch } from 'vue';
import { X } from 'lucide-vue-next';
import type { UiModalProps as Props, UiModalEmits as Emits } from './ui-modal';

const props = withDefaults(defineProps<Props>(), {
  show: false,
  size: 'md',
  closeable: true,
  closeOnOverlayClick: true,
  closeOnEscape: true,
  persistent: false,
  scrollable: false,
  centered: false,
});

const emit = defineEmits<Emits>();

const overlayClasses = computed<string>(() => {
  const classes: string[] = [
    'fixed inset-0 z-50',
    'bg-black bg-opacity-50',
    'transition-opacity duration-300',
    'flex',
  ];

  if (props.centered) {
    classes.push('items-center justify-center');
  } else {
    classes.push('items-start justify-center pt-16');
  }

  if (props.scrollable) {
    classes.push('overflow-y-auto');
  } else {
    classes.push('overflow-hidden');
  }

  return classes.join(' ');
});

const modalClasses = computed<string>(() => {
  const classes: string[] = [
    'bg-white rounded-lg shadow-xl',
    'transform transition-all duration-300',
    'mx-4 my-8',
    'max-h-full',
  ];

  switch (props.size) {
    case 'sm':
      classes.push('max-w-sm w-full');
      break;
    case 'md':
      classes.push('max-w-md w-full');
      break;
    case 'lg':
      classes.push('max-w-lg w-full');
      break;
    case 'xl':
      classes.push('max-w-2xl w-full');
      break;
    case 'full':
      classes.push('max-w-full w-full h-full m-0 rounded-none');
      break;
  }

  if (props.scrollable && props.size !== 'full') {
    classes.push('overflow-hidden flex flex-col');
  }

  return classes.join(' ');
});

const bodyClasses = computed<string>(() => {
  const classes: string[] = [];

  if (props.scrollable) {
    classes.push('overflow-y-auto flex-1');
  }

  return classes.join(' ');
});

const handleClose = (): void => {
  if (!props.persistent) {
    emit('update:show', false);
    emit('close');
  }
};

const handleOverlayClick = (event: MouseEvent): void => {
  if (props.closeOnOverlayClick && event.target === event.currentTarget) {
    handleClose();
  }
};

const handleEscapeKey = (event: KeyboardEvent): void => {
  if (props.closeOnEscape && event.key === 'Escape') {
    handleClose();
  }
};

watch(
  () => props.show,
  newShow => {
    if (newShow) {
      emit('open');
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  }
);

onMounted(() => {
  if (props.show) {
    document.body.style.overflow = 'hidden';
  }
  document.addEventListener('keydown', handleEscapeKey);
});

onUnmounted(() => {
  document.body.style.overflow = '';
  document.removeEventListener('keydown', handleEscapeKey);
});
</script>

<template>
  <teleport to="body">
    <transition
      enter-active-class="transition-opacity duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity duration-300"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="show" :class="overlayClasses" @click="handleOverlayClick">
        <transition
          enter-active-class="transition-all duration-300"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="transition-all duration-300"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <div
            v-if="show"
            :class="modalClasses"
            role="dialog"
            aria-modal="true"
            :aria-labelledby="title ? 'modal-title' : undefined"
            :aria-describedby="description ? 'modal-description' : undefined"
          >
            <div
              v-if="title || closeable || $slots.header"
              class="flex items-center justify-between p-6 border-b border-gray-200"
            >
              <div class="flex-1">
                <h3 v-if="title" id="modal-title" class="text-lg font-medium text-gray-900">
                  {{ title }}
                </h3>
                <p v-if="description" id="modal-description" class="text-sm text-gray-500 mt-1">
                  {{ description }}
                </p>
                <slot name="header" />
              </div>

              <button
                v-if="closeable"
                type="button"
                class="ml-4 p-1 hover:bg-gray-100 rounded-full transition-colors text-gray-400 hover:text-gray-600"
                @click="handleClose"
              >
                <x class="w-5 h-5" />
              </button>
            </div>

            <div :class="['p-6', bodyClasses]">
              <slot />
            </div>

            <div
              v-if="$slots.footer"
              class="flex items-center justify-end gap-3 p-6 border-t border-gray-200"
            >
              <slot name="footer" />
            </div>
          </div>
        </transition>
      </div>
    </transition>
  </teleport>
</template>
