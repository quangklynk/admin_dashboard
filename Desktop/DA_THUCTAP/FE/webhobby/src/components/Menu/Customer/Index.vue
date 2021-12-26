<template>
  <div>
    <el-table :data="data.customers" border style="width: 100%">
      <el-table-column fixed prop="id" label="ID" width="50" align="center">
      </el-table-column>
      <el-table-column prop="name" label="Tên" width="200"> </el-table-column>
      <el-table-column prop="phone" label="SĐT" width="120"> </el-table-column>
      <el-table-column prop="email" label="Email" width="200">
      </el-table-column>
      <el-table-column prop="address" label="Địa Chỉ" width="300">
      </el-table-column>
      <el-table-column prop="image" label="Hình ảnh" width="120" align="center">
        <template slot-scope="scope">
          <p v-if="!scope.row.image">{{ " Trống " }}</p>
          <el-popover v-else placement="bottom" width="330" trigger="click">
            <img class="img-employee" :src="scope.row.image" alt="" />
            <el-button class="fix-heigh" type="primary" slot="reference"
              >Xem ảnh</el-button
            >
          </el-popover>
        </template>
      </el-table-column>
      <el-table-column
        fixed="right"
        label="Operations"
        width="100"
        align="center"
      >
        <template slot-scope="scope">
          <el-button
            v-if="scope.row.flag == 1"
            icon="el-icon-circle-close"
            size="mini"
            type="danger"
            @click="handleDelete(scope.$index, scope.row)"
            >Khóa
          </el-button>
          <el-button
            v-else
            icon="el-icon-refresh-left"
            size="mini"
            type="success"
            @click="handleBack(scope.$index, scope.row)"
            >Mở</el-button
          >
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Customer",
  data() {
    return {
      data: {
        customers: [],
      },
    };
  },
  methods: {
    getAllCustomer() {
      axios
        .get("customer")
        .then((result) => {
          console.log(result);
          this.data.customers = result.data.data;
        })
        .catch((err) => {
          this.$swal.fire({
            icon: "error",
            title: "Oops...",
            text: err,
          });
        });
    },
    handleDelete(index, row) {
      console.log(index, row);
      const swalWithBootstrapButtons = this.$swal.mixin({
        customClass: {
          confirmButton: "btn btn-success btn-margin",
          cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
      });

      swalWithBootstrapButtons
        .fire({
          title: "Bạn có chắc?",
          text: "Tài khoản khách hàng sẽ bị khóa!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Vâng, khóa nó!",
          cancelButtonText: "Không!",
          reverseButtons: true,
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .delete(`/customer/v1/delete/${row.email}`)
              .then((res) => {
                swalWithBootstrapButtons.fire("Đã khóa!", "", "success");
                console.log(res);
              })
              .catch((err) => {
                swalWithBootstrapButtons.fire("Error~~~", `${err}`, "error");
                console.log(err);
              });
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === this.$swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire("Hủy", "", "error");
          }
        });
    },
    handleBack(index, row) {
      this.$swal
        .fire({
          title: "Bạn sẽ phục hồi tài khoản?",
          text: "Sản phẩm sẽ được bày bán lại!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Phục Hồi!",
          cancelButtonText: "Hủy!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .post(`customer/v1/back/${row.email}`)
              .then(() => {
                this.$swal.fire("Đã phục hồi!", "", "success");
              })
              .catch((err) => {
                console.log(err);
              });
          }
        });
    },
  },
  mounted() {
    this.getAllCustomer();
  },
};
</script>

<style scoped></style>
