<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import type { UiSliderProps as Props, UiSliderEmits as Emits } from './ui-slider';

const props = withDefaults(defineProps<Props>(), {
  min: 0,
  max: 100,
  step: 1,
  disabled: false,
  showValue: false,
  tooltip: false,
});

const emit = defineEmits<Emits>();

const localValue = ref(props.modelValue);
const isDragging = ref(false);
const sliderRef = ref<HTMLDivElement | null>(null);
const thumbRef = ref<HTMLDivElement | null>(null);
const tooltipRef = ref<HTMLDivElement | null>(null);

watch(
  () => props.modelValue,
  newValue => {
    localValue.value = newValue;
  }
);

const percentage = computed(() => {
  const range = props.max - props.min;
  return ((localValue.value - props.min) / range) * 100;
});

const trackClasses = computed(() => {
  const classes = ['h-2 rounded-full bg-gray-200', 'relative'];

  if (props.disabled) {
    classes.push('opacity-50 cursor-not-allowed');
  } else {
    classes.push('cursor-pointer');
  }

  return classes.join(' ');
});

const filledTrackClasses = computed(() => {
  return [
    'absolute h-full rounded-full bg-purple-500',
    props.disabled ? 'bg-gray-400' : 'bg-purple-500',
  ].join(' ');
});

const thumbClasses = computed(() => {
  return [
    'absolute w-4 h-4 rounded-full bg-white border-2 border-purple-500',
    'transform -translate-x-1/2 -translate-y-1/2 top-1/2',
    'focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2',
    props.disabled ? 'border-gray-400' : isDragging.value ? 'scale-110' : '',
  ].join(' ');
});

const handleTrackClick = (event: MouseEvent) => {
  if (props.disabled) return;

  const rect = sliderRef.value!.getBoundingClientRect();
  const clickPosition = event.clientX - rect.left;
  const percentage = (clickPosition / rect.width) * 100;

  updateValue(calculateValueFromPercentage(percentage));
};

const handleDragStart = (event: MouseEvent) => {
  if (props.disabled) return;

  isDragging.value = true;
  document.addEventListener('mousemove', handleDrag);
  document.addEventListener('mouseup', handleDragEnd);

  event.preventDefault();
};

const handleDrag = (event: MouseEvent) => {
  if (!isDragging.value) return;

  const rect = sliderRef.value!.getBoundingClientRect();
  const dragPosition = Math.max(0, Math.min(event.clientX - rect.left, rect.width));
  const percentage = (dragPosition / rect.width) * 100;

  updateValue(calculateValueFromPercentage(percentage));

  if (props.tooltip && tooltipRef.value) {
    const thumbRect = thumbRef.value!.getBoundingClientRect();
    tooltipRef.value.style.left = `${thumbRect.left + thumbRect.width / 2}px`;
  }

  emit('input', localValue.value);
};

const handleDragEnd = () => {
  if (!isDragging.value) return;

  isDragging.value = false;
  document.removeEventListener('mousemove', handleDrag);
  document.removeEventListener('mouseup', handleDragEnd);

  emit('change', localValue.value);
};

const calculateValueFromPercentage = (percentage: number) => {
  const range = props.max - props.min;
  let value = (percentage / 100) * range + props.min;

  value = Math.round(value / props.step) * props.step;

  return Math.max(props.min, Math.min(props.max, value));
};

const updateValue = (value: number) => {
  localValue.value = value;
  emit('update:modelValue', value);
};

const handleKeyDown = (event: KeyboardEvent) => {
  if (props.disabled) return;

  let newValue = localValue.value;

  switch (event.key) {
    case 'ArrowRight':
    case 'ArrowUp':
      newValue = Math.min(props.max, localValue.value + props.step);
      break;
    case 'ArrowLeft':
    case 'ArrowDown':
      newValue = Math.max(props.min, localValue.value - props.step);
      break;
    case 'Home':
      newValue = props.min;
      break;
    case 'End':
      newValue = props.max;
      break;
    default:
      return;
  }

  updateValue(newValue);
  emit('change', newValue);
  event.preventDefault();
};
</script>

<template>
  <div class="w-full">
    <div v-if="label" class="mb-2 text-sm font-medium text-gray-700">
      {{ label }}
    </div>

    <div class="flex items-center gap-4">
      <div ref="sliderRef" class="flex-1" @click="handleTrackClick">
        <div :class="trackClasses">
          <div :class="filledTrackClasses" :style="{ width: `${percentage}%` }"></div>

          <div
            ref="thumbRef"
            :class="thumbClasses"
            :style="{ left: `${percentage}%` }"
            tabindex="0"
            role="slider"
            :aria-valuemin="min"
            :aria-valuemax="max"
            :aria-valuenow="localValue"
            :aria-disabled="disabled"
            @mousedown="handleDragStart"
            @keydown="handleKeyDown"
          ></div>

          <div
            v-if="tooltip && isDragging"
            ref="tooltipRef"
            class="absolute -top-8 transform -translate-x-1/2 bg-gray-900 text-white px-2 py-1 rounded text-xs"
          >
            {{ localValue }}
          </div>
        </div>
      </div>

      <div v-if="showValue" class="w-12 text-right text-sm text-gray-700">
        {{ localValue }}
      </div>
    </div>
  </div>
</template>
