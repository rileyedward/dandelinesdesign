<script setup lang="ts">
import { computed, ref } from 'vue';
import { ChevronUp, ChevronDown, Loader2 } from 'lucide-vue-next';
import type {
  UiTableProps as Props,
  UiTableEmits as Emits,
  TableRow,
  TableColumn,
} from './ui-table';

const props = withDefaults(defineProps<Props>(), {
  striped: false,
  bordered: true,
  hoverable: true,
  compact: false,
  loading: false,
  sortOrder: 'asc',
  selectable: false,
  selectedRows: () => [],
  noDataText: 'No data available',
  loadingText: 'Loading...',
});

const emit = defineEmits<Emits>();

const internalSortBy = ref(props.sortBy || '');
const internalSortOrder = ref(props.sortOrder);
const internalSelectedRows = ref([...props.selectedRows]);

const tableClasses = computed(() => {
  const classes = ['w-full'];

  if (props.bordered) {
    classes.push('border border-gray-200');
  }

  return classes.join(' ');
});

const theadClasses = computed(() => {
  const classes = ['bg-gray-50'];

  if (props.bordered) {
    classes.push('border-b border-gray-200');
  }

  return classes.join(' ');
});

const tbodyClasses = computed(() => {
  return 'divide-y divide-gray-200';
});

const getRowClasses = (index: number) => {
  const classes = [];

  if (props.striped && index % 2 === 1) {
    classes.push('bg-gray-50');
  }

  if (props.hoverable) {
    classes.push('hover:bg-gray-100 transition-colors cursor-pointer');
  }

  return classes.join(' ');
};

const getThClasses = (column: TableColumn) => {
  const classes = ['px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider'];

  if (props.compact) {
    classes.push('px-3 py-2');
  }

  switch (column.align) {
    case 'center':
      classes.push('text-center');
      break;
    case 'right':
      classes.push('text-right');
      break;
    default:
      classes.push('text-left');
      break;
  }

  if (column.sortable) {
    classes.push('cursor-pointer select-none hover:bg-gray-100');
  }

  return classes.join(' ');
};

const getTdClasses = (column: TableColumn) => {
  const classes = ['px-6 py-4 whitespace-nowrap text-sm text-gray-900'];

  if (props.compact) {
    classes.push('px-3 py-2');
  }

  switch (column.align) {
    case 'center':
      classes.push('text-center');
      break;
    case 'right':
      classes.push('text-right');
      break;
    default:
      classes.push('text-left');
      break;
  }

  return classes.join(' ');
};

const handleSort = (column: TableColumn) => {
  if (!column.sortable) return;

  let newOrder: 'asc' | 'desc' = 'asc';

  if (internalSortBy.value === column.key) {
    newOrder = internalSortOrder.value === 'asc' ? 'desc' : 'asc';
  }

  internalSortBy.value = column.key;
  internalSortOrder.value = newOrder;

  emit('update:sortBy', column.key);
  emit('update:sortOrder', newOrder);
  emit('sort', column.key, newOrder);
};

const handleRowClick = (row: TableRow, index: number) => {
  emit('row-click', row, index);
};

const handleRowSelect = (row: TableRow, selected: boolean) => {
  if (selected) {
    internalSelectedRows.value.push(row);
  } else {
    const index = internalSelectedRows.value.findIndex(r => r === row);
    if (index > -1) {
      internalSelectedRows.value.splice(index, 1);
    }
  }

  emit('update:selectedRows', [...internalSelectedRows.value]);
  emit('row-select', row, selected);
};

const handleSelectAll = (selected: boolean) => {
  if (selected) {
    internalSelectedRows.value = [...props.data];
  } else {
    internalSelectedRows.value = [];
  }

  emit('update:selectedRows', [...internalSelectedRows.value]);
  emit('select-all', selected);
};

const isRowSelected = (row: TableRow) => {
  return internalSelectedRows.value.includes(row);
};

const isAllSelected = computed(() => {
  return props.data.length > 0 && internalSelectedRows.value.length === props.data.length;
});

const isIndeterminate = computed(() => {
  return (
    internalSelectedRows.value.length > 0 && internalSelectedRows.value.length < props.data.length
  );
});

const getSortIcon = (column: TableColumn) => {
  if (!column.sortable || internalSortBy.value !== column.key) {
    return null;
  }

  return internalSortOrder.value === 'asc' ? ChevronUp : ChevronDown;
};

const renderCellContent = (column: TableColumn, row: TableRow, index: number) => {
  if (column.render) {
    return column.render(row[column.key], row, index);
  }
  return row[column.key];
};
</script>

<template>
  <div class="overflow-x-auto">
    <table :class="tableClasses">
      <thead :class="theadClasses">
        <tr>
          <th v-if="selectable" :class="getThClasses({ key: 'select', label: '', align: 'left' })">
            <input
              type="checkbox"
              :checked="isAllSelected"
              :indeterminate="isIndeterminate"
              class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
              @change="handleSelectAll($event.target.checked)"
            />
          </th>
          <th
            v-for="column in columns"
            :key="column.key"
            :class="getThClasses(column)"
            :style="column.width ? { width: column.width } : undefined"
            @click="handleSort(column)"
          >
            <div class="flex items-center gap-1">
              <span>{{ column.label }}</span>
              <component
                :is="getSortIcon(column)"
                v-if="getSortIcon(column)"
                class="h-4 w-4 text-gray-400"
              />
            </div>
          </th>
        </tr>
      </thead>

      <tbody :class="tbodyClasses">
        <tr v-if="loading">
          <td :colspan="columns.length + (selectable ? 1 : 0)" class="px-6 py-12 text-center">
            <div class="flex items-center justify-center gap-2 text-gray-500">
              <loader2 class="h-5 w-5 animate-spin" />
              <span>{{ loadingText }}</span>
            </div>
          </td>
        </tr>

        <tr v-else-if="data.length === 0">
          <td
            :colspan="columns.length + (selectable ? 1 : 0)"
            class="px-6 py-12 text-center text-gray-500"
          >
            {{ noDataText }}
          </td>
        </tr>

        <tr
          v-for="(row, index) in data"
          v-else
          :key="index"
          :class="getRowClasses(index)"
          @click="handleRowClick(row, index)"
        >
          <td v-if="selectable" :class="getTdClasses({ key: 'select', label: '', align: 'left' })">
            <input
              type="checkbox"
              :checked="isRowSelected(row)"
              class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
              @click.stop
              @change="handleRowSelect(row, $event.target.checked)"
            />
          </td>
          <td v-for="column in columns" :key="column.key" :class="getTdClasses(column)">
            <component
              :is="
                typeof renderCellContent(column, row, index) === 'object'
                  ? renderCellContent(column, row, index)
                  : 'span'
              "
              v-if="typeof renderCellContent(column, row, index) === 'object'"
            />
            <span v-else>{{ renderCellContent(column, row, index) }}</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
