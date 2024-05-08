<script>
import { defineComponent, h } from 'vue'

import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale)
  
  
  export default defineComponent ({
    name: 'BarChart',
    components: {
      Bar
    },
    props: {
        chartId: {
            type: String,
            default: 'bar-chart'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 400
        },
        styles: {
            type: Object,
            default: ()=> {}
        },
        plugins: {
            type: Array,
                default: ()=> {}
        }
    },
    setup(props) {
      const chartData = {
  labels: ['VueJs', 'EmberJs', 'ReactJs', 'AngularJs'],
  datasets: [
    {
      backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
      data: [40, 20, 80, 10]
    }
  ]
}
const chartOptions = {
    responsive: true,
    maintainAspectRatio: false
}

return () =>
      h(Bar, {
        chartData: props.data,
        chartOptions,
        chartId: props.chartId,
        width: props.width,
        height: props.height,
        cssClasses: props.cssClasses,
        styles: props.styles,
        plugins: props.plugins
      })
  }
})

</script>

<style scoped>

</style>