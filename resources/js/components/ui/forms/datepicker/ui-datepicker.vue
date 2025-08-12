<script setup lang="ts">
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { Calendar, ChevronLeft, ChevronRight } from 'lucide-vue-next';
import type { UiDatePickerProps as Props, UiDatePickerEmits as Emits } from './ui-datepicker';

const props = withDefaults(defineProps<Props>(), {
  variant: 'default',
  size: 'md',
  fullWidth: false,
  disabled: false,
  required: false,
  readonly: false,
  format: 'MM/dd/yyyy',
  showWeekNumbers: false,
  firstDayOfWeek: 0,
});

const emit = defineEmits<Emits>();

const isOpen = ref(false);
const inputRef = ref<HTMLInputElement>();
const calendarRef = ref<HTMLDivElement>();
const currentMonth = ref(new Date());

const inputClasses = computed<string>(() => {
  const classes: string[] = [
    'w-full border transition-colors duration-200 cursor-pointer',
    'focus:outline-none focus:ring-2 focus:ring-offset-1',
    'disabled:pointer-events-none disabled:opacity-50 disabled:cursor-not-allowed',
    'flex items-center justify-between',
  ];

  switch (props.variant) {
    case 'default':
      classes.push(
        'border-gray-300 bg-white',
        'hover:border-gray-400',
        'focus:border-purple-500 focus:ring-purple-500'
      );
      break;
    case 'outlined':
      classes.push(
        'border-gray-300 bg-transparent',
        'hover:border-gray-400',
        'focus:border-purple-500 focus:ring-purple-500'
      );
      break;
    case 'filled':
      classes.push(
        'border-gray-200 bg-gray-50',
        'hover:bg-gray-100 hover:border-gray-300',
        'focus:bg-white focus:border-purple-500 focus:ring-purple-500'
      );
      break;
  }

  switch (props.size) {
    case 'sm':
      classes.push('h-8 px-3 text-sm rounded-md');
      break;
    case 'md':
      classes.push('h-9 px-4 text-sm rounded-md');
      break;
    case 'lg':
      classes.push('h-10 px-4 text-base rounded-lg');
      break;
  }

  if (props.errorText) {
    classes.push('border-red-300 bg-red-50', 'focus:border-red-500 focus:ring-red-500');
  }

  return classes.join(' ');
});

const wrapperClasses = computed<string>(() => {
  const classes: string[] = ['relative'];

  if (props.fullWidth) {
    classes.push('w-full');
  }

  return classes.join(' ');
});

const iconClasses = computed<string>(() => {
  return {
    'h-3 w-3': props.size === 'sm',
    'h-4 w-4': props.size === 'md',
    'h-5 w-5': props.size === 'lg',
  };
});

const calendarClasses = computed<string>(() => {
  return [
    'absolute z-50 mt-1 bg-white border border-gray-300 rounded-md shadow-lg',
    'p-4 w-80',
    'top-full left-0',
  ].join(' ');
});

const formatDate = (date: Date | null): string => {
  if (!date) return '';

  const month = (date.getMonth() + 1).toString().padStart(2, '0');
  const day = date.getDate().toString().padStart(2, '0');
  const year = date.getFullYear();

  return `${month}/${day}/${year}`;
};

const parseDate = (dateString: string): Date | null => {
  if (!dateString) return null;

  const parts = dateString.split('/');
  if (parts.length !== 3) return null;

  const month = parseInt(parts[0]) - 1;
  const day = parseInt(parts[1]);
  const year = parseInt(parts[2]);

  const date = new Date(year, month, day);
  if (isNaN(date.getTime())) return null;

  return date;
};

const normalizeDate = (date: Date | string | null): Date | null => {
  if (!date) return null;
  if (typeof date === 'string') return parseDate(date);
  return date;
};

const selectedDate = computed(() => {
  return normalizeDate(props.modelValue);
});

const displayValue = computed(() => {
  if (!selectedDate.value) {
    return props.placeholder || 'Select date';
  }
  return formatDate(selectedDate.value);
});

const monthNames = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July',
  'August',
  'September',
  'October',
  'November',
  'December',
];

const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

const adjustedDayNames = computed(() => {
  const names = [...dayNames];
  for (let i = 0; i < props.firstDayOfWeek; i++) {
    names.push(names.shift()!);
  }
  return names;
});

const currentMonthName = computed(() => {
  return monthNames[currentMonth.value.getMonth()];
});

const currentYear = computed(() => {
  return currentMonth.value.getFullYear();
});

const calendarDays = computed(() => {
  const year = currentMonth.value.getFullYear();
  const month = currentMonth.value.getMonth();

  const firstDay = new Date(year, month, 1);

  const startDate = new Date(firstDay);
  const dayOfWeek = (firstDay.getDay() - props.firstDayOfWeek + 7) % 7;
  startDate.setDate(startDate.getDate() - dayOfWeek);

  const days = [];
  const current = new Date(startDate);

  for (let i = 0; i < 42; i++) {
    days.push({
      date: new Date(current),
      isCurrentMonth: current.getMonth() === month,
      isToday: isSameDay(current, new Date()),
      isSelected: selectedDate.value ? isSameDay(current, selectedDate.value) : false,
      isDisabled: isDateDisabled(current),
    });
    current.setDate(current.getDate() + 1);
  }

  return days;
});

const isSameDay = (date1: Date, date2: Date): boolean => {
  return (
    date1.getFullYear() === date2.getFullYear() &&
    date1.getMonth() === date2.getMonth() &&
    date1.getDate() === date2.getDate()
  );
};

const isDateDisabled = (date: Date): boolean => {
  if (props.disabled) return true;

  const minDate = normalizeDate(props.minDate);
  const maxDate = normalizeDate(props.maxDate);

  if (minDate && date < minDate) return true;
  if (maxDate && date > maxDate) return true;

  if (props.disabledDates) {
    return props.disabledDates.some(disabledDate => {
      const normalized = normalizeDate(disabledDate);
      return normalized ? isSameDay(date, normalized) : false;
    });
  }

  if (props.enabledDates) {
    return !props.enabledDates.some(enabledDate => {
      const normalized = normalizeDate(enabledDate);
      return normalized ? isSameDay(date, normalized) : false;
    });
  }

  return false;
};

const handleDateSelect = (date: Date): void => {
  if (isDateDisabled(date) || props.readonly) return;

  emit('update:modelValue', date);
  emit('change', date);
  isOpen.value = false;
  emit('close');
};

const handlePreviousMonth = (): void => {
  currentMonth.value = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth() - 1
  );
};

const handleNextMonth = (): void => {
  currentMonth.value = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth() + 1
  );
};

const toggleCalendar = (): void => {
  if (props.disabled || props.readonly) return;

  isOpen.value = !isOpen.value;

  if (isOpen.value) {
    if (selectedDate.value) {
      currentMonth.value = new Date(
        selectedDate.value.getFullYear(),
        selectedDate.value.getMonth()
      );
    }
    emit('open');
  } else {
    emit('close');
  }
};

const handleFocus = (event: FocusEvent): void => {
  if (!props.disabled) {
    emit('focus', event);
  }
};

const handleBlur = (event: FocusEvent): void => {
  if (!props.disabled) {
    emit('blur', event);
  }
};

const handleClickOutside = (event: MouseEvent): void => {
  if (
    calendarRef.value &&
    !calendarRef.value.contains(event.target as Node) &&
    inputRef.value &&
    !inputRef.value.contains(event.target as Node)
  ) {
    isOpen.value = false;
    emit('close');
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
  <div :class="wrapperClasses">
    <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }}
      <span v-if="required" class="text-red-500 ml-1">*</span>
    </label>

    <div class="relative">
      <button
        ref="inputRef"
        type="button"
        :class="inputClasses"
        :disabled="disabled"
        :readonly="readonly"
        @click="toggleCalendar"
        @focus="handleFocus"
        @blur="handleBlur"
      >
        <component
          :is="prefixIcon"
          v-if="prefixIcon"
          :class="[iconClasses, 'text-gray-400 mr-2']"
        />

        <span :class="['flex-1 text-left', !selectedDate ? 'text-gray-400' : 'text-gray-900']">
          {{ displayValue }}
        </span>

        <component
          :is="suffixIcon"
          v-if="suffixIcon"
          :class="[iconClasses, 'text-gray-400 ml-2']"
        />
        <calendar v-else :class="[iconClasses, 'text-gray-400 ml-2']" />
      </button>

      <div v-if="isOpen" ref="calendarRef" :class="calendarClasses">
        <div class="flex items-center justify-between mb-4">
          <button
            type="button"
            class="p-1 hover:bg-gray-100 rounded transition-colors"
            @click="handlePreviousMonth"
          >
            <chevron-left class="w-4 h-4" />
          </button>

          <h3 class="text-sm font-medium text-gray-900">
            {{ currentMonthName }} {{ currentYear }}
          </h3>

          <button
            type="button"
            class="p-1 hover:bg-gray-100 rounded transition-colors"
            @click="handleNextMonth"
          >
            <chevron-right class="w-4 h-4" />
          </button>
        </div>

        <div class="grid grid-cols-7 gap-1">
          <div
            v-for="dayName in adjustedDayNames"
            :key="dayName"
            class="text-xs font-medium text-gray-500 text-center p-2"
          >
            {{ dayName }}
          </div>

          <button
            v-for="day in calendarDays"
            :key="day.date.toISOString()"
            type="button"
            :disabled="day.isDisabled"
            :class="[
              'text-sm p-2 rounded hover:bg-gray-100 transition-colors',
              'disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:bg-transparent',
              {
                'text-gray-400': !day.isCurrentMonth,
                'text-gray-900': day.isCurrentMonth && !day.isSelected && !day.isToday,
                'bg-purple-500 text-white hover:bg-purple-600': day.isSelected,
                'bg-blue-100 text-blue-800': day.isToday && !day.isSelected,
                'font-bold': day.isToday,
              },
            ]"
            @click="handleDateSelect(day.date)"
          >
            {{ day.date.getDate() }}
          </button>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-200">
          <button
            type="button"
            class="text-sm text-purple-600 hover:text-purple-800 transition-colors"
            @click="handleDateSelect(new Date())"
          >
            Today
          </button>
        </div>
      </div>
    </div>

    <p v-if="helperText && !errorText" class="mt-1 text-sm text-gray-500">
      {{ helperText }}
    </p>

    <p v-if="errorText" class="mt-1 text-sm text-red-600">
      {{ errorText }}
    </p>
  </div>
</template>
