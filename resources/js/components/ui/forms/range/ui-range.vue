<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import type { UiRangeProps as Props, UiRangeEmits as Emits } from './ui-range';

const props = withDefaults(defineProps<Props>(), {
  min: 0,
  max: 100,
  step: 1,
  disabled: false,
  showValues: false,
  tooltip: false,
});

const emit = defineEmits<Emits>();

const localValue = ref<[number, number]>([...props.modelValue]);
const isDraggingStart = ref(false);
const isDraggingEnd = ref(false);
const rangeRef = ref<HTMLDivElement | null>(null);
const startThumbRef = ref<HTMLDivElement | null>(null);
const endThumbRef = ref<HTMLDivElement | null>(null);
const startTooltipRef = ref<HTMLDivElement | null>(null);
const endTooltipRef = ref<HTMLDivElement | null>(null);

watch(
  () => props.modelValue,
  newValue => {
    localValue.value = [...newValue];
  }
);

const startPercentage = computed(() => {
  const range = props.max - props.min;
  return ((localValue.value[0] - props.min) / range) * 100;
});

const endPercentage = computed(() => {
  const range = props.max - props.min;
  return ((localValue.value[1] - props.min) / range) * 100;
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
  return ['absolute h-full rounded-full', props.disabled ? 'bg-gray-400' : 'bg-purple-500'].join(
    ' '
  );
});

const thumbClasses = computed(() => {
  return [
    'absolute w-4 h-4 rounded-full bg-white border-2 border-purple-500',
    'transform -translate-x-1/2 -translate-y-1/2 top-1/2',
    'focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2',
    props.disabled ? 'border-gray-400' : '',
  ].join(' ');
});

const handleTrackClick = (event: MouseEvent) => {
  if (props.disabled) return;

  const rect = rangeRef.value!.getBoundingClientRect();
  const clickPosition = event.clientX - rect.left;
  const percentage = (clickPosition / rect.width) * 100;
  const value = calculateValueFromPercentage(percentage);

  const [start, end] = localValue.value;
  const distanceToStart = Math.abs(value - start);
  const distanceToEnd = Math.abs(value - end);

  if (distanceToStart <= distanceToEnd) {
    updateValue([value, end]);
  } else {
    updateValue([start, value]);
  }
};

const handleStartDragStart = (event: MouseEvent) => {
  if (props.disabled) return;

  isDraggingStart.value = true;
  document.addEventListener('mousemove', handleStartDrag);
  document.addEventListener('mouseup', handleStartDragEnd);

  event.preventDefault();
};

const handleEndDragStart = (event: MouseEvent) => {
  if (props.disabled) return;

  isDraggingEnd.value = true;
  document.addEventListener('mousemove', handleEndDrag);
  document.addEventListener('mouseup', handleEndDragEnd);

  event.preventDefault();
};

const handleStartDrag = (event: MouseEvent) => {
  if (!isDraggingStart.value) return;

  const rect = rangeRef.value!.getBoundingClientRect();
  const dragPosition = Math.max(0, Math.min(event.clientX - rect.left, rect.width));
  const percentage = (dragPosition / rect.width) * 100;
  const value = calculateValueFromPercentage(percentage);

  if (value <= localValue.value[1]) {
    updateValue([value, localValue.value[1]]);
  }

  if (props.tooltip && startTooltipRef.value) {
    const thumbRect = startThumbRef.value!.getBoundingClientRect();
    startTooltipRef.value.style.left = `${thumbRect.left + thumbRect.width / 2}px`;
  }

  emit('input', localValue.value);
};

const handleEndDrag = (event: MouseEvent) => {
  if (!isDraggingEnd.value) return;

  const rect = rangeRef.value!.getBoundingClientRect();
  const dragPosition = Math.max(0, Math.min(event.clientX - rect.left, rect.width));
  const percentage = (dragPosition / rect.width) * 100;
  const value = calculateValueFromPercentage(percentage);

  if (value >= localValue.value[0]) {
    updateValue([localValue.value[0], value]);
  }

  if (props.tooltip && endTooltipRef.value) {
    const thumbRect = endThumbRef.value!.getBoundingClientRect();
    endTooltipRef.value.style.left = `${thumbRect.left + thumbRect.width / 2}px`;
  }

  emit('input', localValue.value);
};

const handleStartDragEnd = () => {
  if (!isDraggingStart.value) return;

  isDraggingStart.value = false;
  document.removeEventListener('mousemove', handleStartDrag);
  document.removeEventListener('mouseup', handleStartDragEnd);

  emit('change', localValue.value);
};

const handleEndDragEnd = () => {
  if (!isDraggingEnd.value) return;

  isDraggingEnd.value = false;
  document.removeEventListener('mousemove', handleEndDrag);
  document.removeEventListener('mouseup', handleEndDragEnd);

  emit('change', localValue.value);
};

const calculateValueFromPercentage = (percentage: number) => {
  const range = props.max - props.min;
  let value = (percentage / 100) * range + props.min;

  value = Math.round(value / props.step) * props.step;

  return Math.max(props.min, Math.min(props.max, value));
};

const updateValue = (value: [number, number]) => {
  localValue.value = value;
  emit('update:modelValue', value);
};

const handleStartKeyDown = (event: KeyboardEvent) => {
  if (props.disabled) return;

  let newStart = localValue.value[0];
  const end = localValue.value[1];

  switch (event.key) {
    case 'ArrowRight':
    case 'ArrowUp':
      newStart = Math.min(end, newStart + props.step);
      break;
    case 'ArrowLeft':
    case 'ArrowDown':
      newStart = Math.max(props.min, newStart - props.step);
      break;
    case 'Home':
      newStart = props.min;
      break;
    case 'End':
      newStart = end;
      break;
    default:
      return;
  }

  updateValue([newStart, end]);
  emit('change', localValue.value);
  event.preventDefault();
};

const handleEndKeyDown = (event: KeyboardEvent) => {
  if (props.disabled) return;

  const start = localValue.value[0];
  let newEnd = localValue.value[1];

  switch (event.key) {
    case 'ArrowRight':
    case 'ArrowUp':
      newEnd = Math.min(props.max, newEnd + props.step);
      break;
    case 'ArrowLeft':
    case 'ArrowDown':
      newEnd = Math.max(start, newEnd - props.step);
      break;
    case 'Home':
      newEnd = start;
      break;
    case 'End':
      newEnd = props.max;
      break;
    default:
      return;
  }

  updateValue([start, newEnd]);
  emit('change', localValue.value);
  event.preventDefault();
};
</script>

<template>
  <div class="w-full">
    <div v-if="label" class="mb-2 text-sm font-medium text-gray-700">
      {{ label }}
    </div>

    <div class="flex items-center gap-4">
      <div ref="rangeRef" class="flex-1" @click="handleTrackClick">
        <div :class="trackClasses">
          <div
            :class="filledTrackClasses"
            :style="{
              left: `${startPercentage}%`,
              width: `${endPercentage - startPercentage}%`,
            }"
          ></div>

          <div
            ref="startThumbRef"
            :class="thumbClasses"
            :style="{ left: `${startPercentage}%` }"
            tabindex="0"
            role="slider"
            :aria-valuemin="min"
            :aria-valuemax="localValue[1]"
            :aria-valuenow="localValue[0]"
            :aria-disabled="disabled"
            @mousedown="handleStartDragStart"
            @keydown="handleStartKeyDown"
          ></div>

          <div
            ref="endThumbRef"
            :class="thumbClasses"
            :style="{ left: `${endPercentage}%` }"
            tabindex="0"
            role="slider"
            :aria-valuemin="localValue[0]"
            :aria-valuemax="max"
            :aria-valuenow="localValue[1]"
            :aria-disabled="disabled"
            @mousedown="handleEndDragStart"
            @keydown="handleEndKeyDown"
          ></div>

          <div
            v-if="tooltip && isDraggingStart"
            ref="startTooltipRef"
            class="absolute -top-8 transform -translate-x-1/2 bg-gray-900 text-white px-2 py-1 rounded text-xs"
          >
            {{ localValue[0] }}
          </div>

          <div
            v-if="tooltip && isDraggingEnd"
            ref="endTooltipRef"
            class="absolute -top-8 transform -translate-x-1/2 bg-gray-900 text-white px-2 py-1 rounded text-xs"
          >
            {{ localValue[1] }}
          </div>
        </div>
      </div>

      <div v-if="showValues" class="w-24 text-right text-sm text-gray-700">
        {{ localValue[0] }} - {{ localValue[1] }}
      </div>
    </div>
  </div>
</template>
