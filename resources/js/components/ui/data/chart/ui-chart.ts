import type { ChartType, ChartData, ChartOptions, Chart } from 'chart.js';

export interface UiChartProps {
  type: ChartType;
  data: ChartData;
  options?: ChartOptions;
  width?: number;
  height?: number;
  responsive?: boolean;
  maintainAspectRatio?: boolean;
}

export interface UiChartEmits {
  (event: 'chart-created', chart: Chart): void;

  (event: 'chart-updated', chart: Chart): void;
  (event: 'chart-destroyed'): void;
}
