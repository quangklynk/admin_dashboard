<template>
  <div>
    <el-table
      :data="data.importSticker"
      style="width: 100%"
      height="470"
      border
    >
      <el-table-column type="expand" label="Chi tiết" width="100">
        <template slot-scope="props">
          <div
            v-for="(item, index) in props.row.detail_enter_sticker"
            :key="index"
          >
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
      <el-table-column prop="employee.name" label="Nhân viên" width="120">
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
      <el-table-column
        align="center"
        prop="flag"
        label="Trạng thái"
        width="120"
        :filters="[
          { text: 'Duyệt', value: 'Duyệt' },
          { text: 'Chưa duyệt', value: 'Chưa duyệt' },
        ]"
        :filter-method="filterTag"
        filter-placement="bottom-end"
      >
        <template slot-scope="scope">
          <el-tag
            :type="scope.row.flag == '0' ? 'primary' : 'success'"
            disable-transitions
            >{{ scope.row.flag == "0" ? "Chưa duyệt" : "Duyệt" }}</el-tag
          >
        </template>
      </el-table-column>
      <el-table-column prop="total" label="Tổng tiền" width="150">
        <template slot-scope="scope">
          {{ formatPrice(scope.row.total) }}
        </template>
      </el-table-column>
      <el-table-column prop="updated_at" label="Ngày duyệt" width="150">
        <template slot-scope="scope">
          <p v-if="scope.row.flag">
            {{ scope.row.updated_at | formatDate }}
          </p>
          <p v-else>Chưa duyệt</p>
        </template>
      </el-table-column>
      <el-table-column
        fixed="right"
        align="center"
        label="Thao tác"
        width="200"
      >
        <template slot-scope="scope" v-if="role == 'admin'">
          <el-button
            v-if="scope.row.flag == 0"
            size="mini"
            @click="handleEdit(scope.$index, scope.row)"
            icon="el-icon-edit"
            >Duyệt</el-button
          >
          <el-button
            v-if="scope.row.flag == 0"
            size="mini"
            type="danger"
            icon="el-icon-delete"
            @click="handleDelete(scope.$index, scope.row)"
            >Xóa</el-button
          >
          <el-button
            v-if="scope.row.flag == 1"
            size="mini"
            type="success"
            icon="el-icon-check"
            >Đã duyệt</el-button
          >
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "",
  data() {
    return {
      search: "",
      data: {
        importSticker: [],
      },
      role: this.$store.getters.role,
    };
  },
  methods: {
    filterTag(value, row) {
      console.log(row);
      return row.flag === value;
    },
    getAllImportSticker() {
      axios
        .get(`entersticker`)
        .then((result) => {
          this.data.importSticker = result.data.data;
          this.data.importSticker.forEach((element) => {
            element.total = 0;
            element.detail_enter_sticker.forEach((element1) => {
              element.total += element1.price * element1.unit;
            }, element.total);
          });
        })
        .catch((err) => {
          this.$swal.fire({
            icon: "error",
            title: "Oops...",
            text: err,
          });
        });
    },
    handleEdit(index, row) {
      axios
        .patch(`entersticker/${row.id}`)
        .then((result) => {
          console.log(result);
          if (result.data.status == "failed") {
            this.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Đơn đã duyệt",
            });
          } else {
            this.$swal({
              icon: "success",
              title: "Duyệt thành công",
              showConfirmButton: false,
            });
            this.getAllImportSticker();
          }
        })
        .catch((err) => {
          this.$swal.fire({
            icon: "error",
            title: "Oops...",
            text: err,
          });
          console.log(err);
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
          title: "Bạn có chắc chứ?",
          text: "Bạn sẽ không phục hồi được sau khi xóa!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Vâng, xóa nó!",
          cancelButtonText: "Không!",
          reverseButtons: true,
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .delete(`entersticker/${row.id}`)
              .then((res) => {
                this.getAllImportSticker();
                if (res.data.status == '"failed') {
                  swalWithBootstrapButtons.fire(
                    "Lỗi~~~",
                    `Không xóa được`,
                    "error"
                  );
                } else {
                  swalWithBootstrapButtons.fire("Đã Xóa!", "", "success");
                }
              })
              .catch((err) => {
                swalWithBootstrapButtons.fire("Lỗi~~~", `${err}`, "error");
              });
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === this.$swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire("Đã hủy", "", "error");
          }
        });
    },
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " ₫";
    },
  },
  mounted() {
    this.getAllImportSticker();
  },
};
</script>

<style scoped>
</style>