export interface TableColumn {
  key: string;
  label: string;
  sortable?: boolean;
  width?: string;
  align?: 'left' | 'center' | 'right';
  render?: (value: any, row: TableRow, index: number) => any;
}

export interface TableRow {
  [key: string]: any;
}

export interface UiTableProps {
  columns: TableColumn[];
  data: TableRow[];
  striped?: boolean;
  bordered?: boolean;
  hoverable?: boolean;
  compact?: boolean;
  loading?: boolean;
  sortBy?: string;
  sortOrder?: 'asc' | 'desc';
  selectable?: boolean;
  selectedRows?: any[];
  noDataText?: string;
  loadingText?: string;
}

export interface UiTableEmits {
  (event: 'row-click', row: TableRow, index: number): void;
  (event: 'row-select', row: TableRow, selected: boolean): void;
  (event: 'select-all', selected: boolean): void;
  (event: 'sort', column: string, order: 'asc' | 'desc'): void;
  (event: 'update:selectedRows', rows: any[]): void;
  (event: 'update:sortBy', column: string): void;
  (event: 'update:sortOrder', order: 'asc' | 'desc'): void;
}
