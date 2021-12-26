
<script>
import { Line, mixins  } from "vue-chartjs";
const { reactiveProp } = mixins;
export default {
  extends: Line,
  mixins: [reactiveProp],
  props: {
    chartdata: {
      type: Object,
      default: null,
    },
    options: {
      type: Object,
      default: null,
    },
  },
  mounted() {
    this.renderChart(this.chartdata, { responsive: true});
    // this.renderChart(
    //   {
    //     labels: this.labels,
    //     datasets: this.datasets,
    //   },
    //   { responsive: true, maintainAspectRatio: false }
    // );
  },
};
</script>

