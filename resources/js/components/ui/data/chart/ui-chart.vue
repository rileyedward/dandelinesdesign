<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount, watch, nextTick } from 'vue';
import {
  Chart,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  BarController,
  LineController,
  PieController,
  DoughnutController,
} from 'chart.js';
import type { UiChartProps as Props, UiChartEmits as Emits } from './ui-chart';

Chart.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  BarController,
  LineController,
  PieController,
  DoughnutController
);

const props = withDefaults(defineProps<Props>(), {
  width: 400,
  height: 200,
  responsive: true,
  maintainAspectRatio: true,
});

const emit = defineEmits<Emits>();

const canvasRef = ref<HTMLCanvasElement>();
let chartInstance: Chart | null = null;

const createChart = async (): Promise<void> => {
  if (!canvasRef.value) return;

  await nextTick();

  const ctx = canvasRef.value.getContext('2d');
  if (!ctx) return;

  const config = {
    type: props.type,
    data: props.data,
    options: {
      responsive: props.responsive,
      maintainAspectRatio: props.maintainAspectRatio,
      ...props.options,
    },
  };

  chartInstance = new Chart(ctx, config);
  emit('chart-created', chartInstance);
};

const updateChart = (): void => {
  if (!chartInstance) return;

  chartInstance.data = props.data;
  if (props.options) {
    chartInstance.options = {
      responsive: props.responsive,
      maintainAspectRatio: props.maintainAspectRatio,
      ...props.options,
    };
  }
  chartInstance.update();
  emit('chart-updated', chartInstance);
};

const destroyChart = (): void => {
  if (chartInstance) {
    chartInstance.destroy();
    chartInstance = null;
    emit('chart-destroyed');
  }
};

watch(
  () => props.data,
  () => {
    updateChart();
  },
  { deep: true }
);

watch(
  () => props.options,
  () => {
    updateChart();
  },
  { deep: true }
);

watch(
  () => props.type,
  () => {
    destroyChart();
    createChart();
  }
);

onMounted(() => {
  createChart();
});

onBeforeUnmount(() => {
  destroyChart();
});
</script>

<template>
  <div class="ui-chart">
    <canvas ref="canvasRef" :width="width" :height="height" />
  </div>
</template>

<style scoped>
.ui-chart {
  position: relative;
  width: 100%;
  height: 100%;
}

canvas {
  max-width: 100%;
  height: auto;
}
</style>
