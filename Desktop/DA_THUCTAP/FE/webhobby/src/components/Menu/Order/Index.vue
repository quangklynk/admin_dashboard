<template>
  <el-table :data="data.orders" style="width: 100%" height="470" border>
    <el-table-column type="expand" label="Chi tiết" width="100">
      <template slot-scope="props">
        <div v-for="(item, index) in props.row.detail_order" :key="index">
          <p>Mã sản phẩm: {{ item.idProduct }}</p>
          <p>Số lượng: {{ item.unit }}</p>
          <p>Giá/Sp: {{ formatPrice(item.price || 0) }}</p>
          <el-divider></el-divider>
        </div>
      </template>
    </el-table-column>
    <el-table-column
      prop="id"
      label="ID"
      width="70"
      align="center"
      column-key="id"
      sortable
    >
    </el-table-column>
    <el-table-column
      prop="status.description"
      label="Trạng thái"
      width="120"
      :filters="[
        { text: 'Chờ', value: 1 },
        { text: 'Xác Nhận', value: 2 },
        { text: 'Hoàn Thành', value: 3 },
        { text: 'Đã Hủy', value: 4 },
        { text: 'Đã Đánh Giá', value: 5 },
      ]"
      :filter-method="filterTag"
      filter-placement="bottom-end"
    >
    </el-table-column>
    <el-table-column
      prop="created_at"
      label="Ngày tạo"
      width="150"
      column-key="created_at"
      sortable
    >
      <template slot-scope="scope">
        {{ scope.row.created_at | formatDate }}
      </template>
    </el-table-column>
    <el-table-column prop="employee.name" label="Nhân viên" width="150">
    </el-table-column>
    <el-table-column prop="customer.name" label="Khách hàng" width="150">
    </el-table-column>
    <el-table-column prop="avgRate" label="Đánh giá" width="250">
      <template slot-scope="scope">
        <el-rate
          v-model="scope.row.avgRate"
          disabled
          show-score
          text-color="#ff9900"
          score-template="{value} điểm"
        >
        </el-rate>
      </template>
    </el-table-column>
    <el-table-column
      prop="total"
      label="Tổng tiền"
      width="150"
      column-key="total"
      sortable
    >
      <template slot-scope="scope">
        {{ formatPrice(scope.row.total) }}
      </template>
    </el-table-column>
    <el-table-column prop="address" label="Địa chỉ" width="300">
    </el-table-column>
    <el-table-column prop="note" label="Ghi Chú" width="300"> </el-table-column>
    <el-table-column fixed="right" label="Thao tác" width="150" align="center">
      <template slot-scope="scope">
        <el-button
          v-if="scope.row.idStatus == 1"
          @click="confirmOrder(scope.row.id)"
          type="primary"
          size="small"
          >Duyệt</el-button
        >
        <el-button
          v-if="scope.row.idStatus == 1"
          type="danger"
          size="small"
          @click="cancelOrder(scope.row.id)"
          >Hủy</el-button
        >
        <el-button
          v-if="scope.row.idStatus == 2"
          @click="completeOrder(scope.row.id)"
          type="success"
          size="small"
          >Xác nhận</el-button
        >
      </template>
    </el-table-column>
  </el-table>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      tableData: [
        {
          date: "2016-05-03",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-02",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-04",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-01",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-08",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-06",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
        {
          date: "2016-05-07",
          name: "Tom",
          state: "California",
          city: "Los Angeles",
          address: "No. 189, Grove St, Los Angeles",
          zip: "CA 90036",
        },
      ],
      data: {
        orders: [],
        status: [],
      },
      order: {
        idEmployee: this.$store.getters.id,
      },
    };
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " ₫";
    },
    getAllOrder() {
      axios
        .get("order")
        .then((result) => {
          this.data.orders = result.data.data;
          this.data.orders.forEach((element) => {
            element.total = 0;
            element.avgRate = element.rate.length ? element.rate[0].vote : 0;
            element.detail_order.forEach((element1) => {
              element.total += element1.price * element1.unit;
            }, element.total);
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllStatus() {
      axios
        .get()
        .then((result) => {
          this.data.status = result.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    cancelOrder(id) {
      const swalWithBootstrapButtons = this.$swal.mixin({
        customClass: {
          confirmButton: "el-button el-button--success",
          cancelButton: "el-button el-button--danger",
        },
        buttonsStyling: false,
      });

      swalWithBootstrapButtons
        .fire({
          title: "Bạn có chắc?",
          text: "Đơn hàng sẽ hủy và bạn sẽ không nhận được hàng!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Vâng, xóa hết!",
          cancelButtonText: "Hủy!",
          reverseButtons: true,
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .patch(`order/cancel/${id}`, this.order)
              .then((result) => {
                swalWithBootstrapButtons.fire("Đã xóa!", result, "success");
                this.getAllOrder();
              })
              .catch((err) => {
                swalWithBootstrapButtons.fire("Lỗi", err, "error");
              });
          } else if (result.dismiss === this.$swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire("Đã hủy", "", "error");
          }
        });
    },
    confirmOrder(id) {
      this.$swal
        .fire({
          title: "Bạn sẽ xác nhận đơn hàng và đi giao?",
          text: "Đơn hàng sẽ trong trạng thái xác nhận và chờ nhận tiền!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Vâng!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .patch(`order/confirm/${id}`, this.order)
              .then(() => {
                this.$swal.fire("Đã duyệt!", "", "success");
                this.getAllOrder();
              })
              .catch((err) => {
                this.$swal.fire("Lỗi server!", err, "error");
                console.log(err);
              });
          }
        });
    },
    completeOrder(id) {
      this.$swal
        .fire({
          title: "Đơn này sẽ hoàn thành?",
          text: "",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Vâng!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .patch(`order/complete/${id}`, this.order)
              .then(() => {
                this.$swal.fire("Đã hoàn thành!", "", "success");
                this.getAllOrder();
              })
              .catch((err) => {
                this.$swal.fire("Lỗi server!", err, "error");
                console.log(err);
              });
          }
        });
    },
    filterTag(value, row) {
      console.log(row);
      return row.status.id === value;
    },
  },
  mounted() {
    this.getAllOrder();
  },
};
</script>

<style></style>
