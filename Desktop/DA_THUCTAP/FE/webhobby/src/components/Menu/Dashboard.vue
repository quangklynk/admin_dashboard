<template>
  <div class="wrap-page-dash">
    <div class="container-info">
      <div class="bg-member info-shop">
        <h3><i class="el-icon-check"></i> Đơn hoàn thành</h3>
        <p class="index-num">{{ data.statistical.completeOrder }}</p>
        <router-link to="/menu/order">
          <p class="link-go">Đi đến <i class="el-icon-right"></i></p
        ></router-link>
      </div>
      <div class="bg-product info-shop">
        <h3><i class="el-icon-s-promotion"></i> Đang vận chuyển</h3>
        <p class="index-num">{{ data.statistical.shippingOrder }}</p>
        <router-link to="/menu/order">
          <p class="link-go">Đi đến <i class="el-icon-right"></i></p
        ></router-link>
      </div>
      <div class="bg-order info-shop">
        <h3><i class="el-icon-warning-outline"></i> Đơn hủy</h3>
        <p class="index-num">{{ data.statistical.cancelOrder }}</p>
        <router-link to="/menu/order">
          <p class="link-go">Đi đến <i class="el-icon-right"></i></p
        ></router-link>
      </div>
      <div class="bg-employee info-shop">
        <h3><i class="el-icon-loading"></i> Đơn chờ xác nhận</h3>
        <p class="index-num">{{ data.statistical.waitForConfirmation }}</p>
        <router-link to="/menu/order">
          <p class="link-go">Đi đến <i class="el-icon-right"></i></p
        ></router-link>
      </div>
    </div>

    <div class="container-chart">
      <div class="wapper-chart">
        <line-chart v-if="loaded" :chartdata="chartdata" :options="options" />
      </div>

      <div class="wapper-chart">
        <line-chart v-if="loaded" :chartdata="chartdata1" :options="options1" />
      </div>
    </div>

    <div class="wapper-calendar">
      <div class="container-sub-notifi">
        <router-link to="/menu/blog">
          <div class="info-sub" style="background: #3b5998">
            <h3><i class="el-icon-s-check"></i> Blog</h3>
            <p class="index-num">{{ data.statistical.blog }}</p>
          </div>
        </router-link>
         <router-link to="/menu/slide">
        <div class="info-sub" style="background: #1ab4ef">
          <h3><i class="el-icon-picture"></i> Slide</h3>
          <p class="index-num">{{ data.statistical.slide }}</p>
        </div>
         </router-link>
         <router-link to="/menu/customer">
        <div class="info-sub" style="background: #2eb85c">
          <h3><i class="el-icon-user-solid"></i> Khách hàng</h3>
          <p class="index-num">{{ data.statistical.customer }}</p>
        </div>
         </router-link>
         <router-link to="/menu/employee">
        <div class="info-sub" style="background: #e46651">
          <h3><i class="el-icon-s-custom"></i> Nhân viên</h3>
          <p class="index-num">{{ data.statistical.employee }}</p>
        </div>
         </router-link>
         <router-link to="/menu/product">
        <div class="info-sub" style="background: #f8ab27">
          <h3><i class="el-icon-receiving"></i> Sản phẩm</h3>
          <p class="index-num">{{ data.statistical.product }}</p>
        </div>
         </router-link>
         <router-link to="/menu/product">
        <div class="info-sub" style="background: #e55353">
          <h3><i class="el-icon-error"></i> Hết hàng</h3>
          <p class="index-num">{{ data.statistical.outOfStock }}</p>
        </div>
         </router-link>
      </div>
      <div>
        <el-calendar v-model="value" id="calendar"> </el-calendar>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import LineChart from "./Chart.vue";
export default {
  name: "dashboard",
  data() {
    return {
      data: {
        weeklyRevenue: [],
        monthlyRevenue: [],
        statistical: [],
      },
      loaded: false,
      chartdata: {
        labels: [
          "Chủ nhật",
          "Thứ 2",
          "Thứ 3",
          "Thứ 4",
          "Thứ 5",
          "Thứ 6",
          "Thứ 7",
        ],
        datasets: [
          {
            label: "Doanh thu theo tuần",
            fill: false,
            borderColor: "#2554FF",
            backgroundColor: "#2554FF",
            borderWidth: 1,
            data: [],
          },
        ],
      },
      options: {
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
              gridLines: {
                display: true,
              },
            },
          ],
          xAxes: [
            {
              gridLines: {
                display: false,
              },
            },
          ],
        },
        legend: {
          display: true,
        },
        responsive: true,
        maintainAspectRatio: false,
      },

      chartdata1: {
        labels: [
          "Tháng 1",
          "Tháng 2",
          "Tháng 3",
          "Tháng 4",
          "Tháng 5",
          "Tháng 6",
          "Tháng 7",
          "Tháng 8",
          "Tháng 9",
          "Tháng 10",
          "Tháng 11",
          "Tháng 12",
        ],
        datasets: [
          {
            label: "Doanh thu theo tháng",
            fill: false,
            borderColor: "#2554FF",
            backgroundColor: "#2554FF",
            borderWidth: 1,
            data: [],
          },
        ],
      },
      options1: {
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
              gridLines: {
                display: true,
              },
            },
          ],
          xAxes: [
            {
              gridLines: {
                display: false,
              },
            },
          ],
        },
        legend: {
          display: true,
        },
        responsive: true,
        maintainAspectRatio: false,
      },
      value: new Date(),
    };
  },
  components: { LineChart },
  methods: {
    getRevenue() {
      axios
        .get(`revenue`)
        .then((result) => {
          console.log(result);
          this.data.monthlyRevenue = result.data.data1[0];
          for (const key in this.data.monthlyRevenue) {
            this.chartdata1.datasets[0].data.push(
              this.data.monthlyRevenue[key]
            );
          }
          this.data.weeklyRevenue = result.data.data[0];
          for (const key in this.data.weeklyRevenue) {
            this.chartdata.datasets[0].data.push(this.data.weeklyRevenue[key]);
          }
          this.loaded = true;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getOverview() {
      axios
        .get(`statistical`)
        .then((result) => {
          this.data.statistical = result.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  async mounted() {
    this.getRevenue();
    this.getOverview();
  },
};
</script>

<style>
.info-sub {
  border-radius: 4px;
  background-color: #fff;
  min-height: 103px;
  color: #fff;
}

.info-sub .index-num {
  font-weight: 600;
  padding-top: 10px;
}

.info-sub h3 {
  font-size: 18px;
  padding-top: 14px;
  display: block;
}

.container-sub-notifi {
  margin-bottom: 15px;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 10px;
  justify-content: center;
  position: relative;
}

.wrap-page-dash {
  display: flex;
  flex-wrap: wrap;
}

.wapper-chart {
  flex-basis: 50%;
  align-self: center;
  background-color: #fff;
  padding: 20px;
  margin: 20px 0;
}

.container-info {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  width: 100%;
  gap: 15px;
}

.info-shop {
  min-height: 130px;
  color: #fff;
  display: inline-block;
  line-height: 1;
  white-space: nowrap;
  cursor: pointer;
  background: #fff;
  border: 1px solid #dcdfe6;
  -webkit-appearance: none;
  text-align: center;
  box-sizing: border-box;
  outline: 0;
  margin: 0;
  transition: 0.1s;
  font-weight: 500;
  padding: 12px 20px;
  font-size: 14px;
  border-radius: 4px;
  position: relative;
}

.info-shop h3 {
  font-size: 22px;
}

.info-shop .index-num {
  font-size: 2rem;
  font-weight: 700;
  margin-top: 20px;
}

.link-go {
  position: absolute;
  bottom: 0px;
  right: 15px;
  color: #fff !important;
  text-align: right;
  font-weight: 500;
}

.link-go:hover {
  transform: scale(1.2);
}

.bg-member {
  background: #009f6b !important;
  background: linear-gradient(45deg, #1cac78, #009f6b 78%) !important;
}

.bg-product {
  background: linear-gradient(45deg, #39f, #2982cc) !important;
  border-color: #2982cc !important;
}

.bg-employee {
  background: linear-gradient(45deg, #f9b115, #f6960b) !important;
  border-color: #f6960b !important;
}

.bg-order {
  background: linear-gradient(45deg, #e55353, #d93737) !important;
  border-color: #d93737 !important;
}

.wapper-calendar {
  flex-basis: 50%;
  height: 200px;
  padding: 20px;
}
</style>
