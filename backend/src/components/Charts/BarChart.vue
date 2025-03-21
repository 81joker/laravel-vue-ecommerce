<template>
<!-- <div>
  <Bar v-if="chartData" :data="chartData" :options="chartOptions" />
</div> -->
<pre>
    {{ data }}
  </pre>
</template>

<script setup>
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'

import { Bar } from 'vue-chartjs'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)


const props = defineProps({
  data: {
    type: Object,
    required: false
  },  
  options: {
    type: Object,
    required: true
  }
})

const chartData = props.data

const options = {
  responsive: true,
  maintainAspectRatio: false
}
</script>
