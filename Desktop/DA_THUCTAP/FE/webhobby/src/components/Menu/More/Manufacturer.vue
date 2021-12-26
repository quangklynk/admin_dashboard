<template>
  <div class="wrap-component">
    <!-- Thêm -->
    <el-button
      icon="el-icon-circle-plus-outline"
      class="btn-add"
      type="primary"
      @click="dialogFormAdd = true"
      >Thêm</el-button
    >
    <el-dialog title="Thêm hãng mới" :visible.sync="dialogFormAdd">
      <el-form :model="addform">
        <el-form-item label="Tên Hãng" :label-width="formLabelWidth">
          <el-input v-model="addform.name" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormAdd = false">Hủy Bỏ</el-button>
        <el-button type="primary" @click="handleSubmit">Ghi</el-button>
      </span>
    </el-dialog>

    <!-- Sửa -->
    <el-dialog title="Chỉnh sửa hãng" :visible.sync="dialogFormEdit">
      <el-form :model="editform">
        <el-form-item label="Tên Hãng" :label-width="formLabelWidth">
          <el-input v-model="editform.name" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormEdit = false">Hủy Bỏ</el-button>
        <el-button type="primary" @click="editManufacturer">Ghi</el-button>
      </span>
    </el-dialog>

    <el-table
      slot="empty"
      empty-text="Bảng Rỗng"
      :data="
        manufacturer.filter(
          (data) =>
            !search || data.name.toLowerCase().includes(search.toLowerCase())
        )
      "
    >
      <el-table-column prop="id" label="ID"> </el-table-column>
      <el-table-column prop="name" label="Tên Hãng"> </el-table-column>
      <el-table-column>
        <template slot="header">
          <!-- <el-input v-model="search" size="mini" placeholder="Type to search" /> -->
          <input
            type="text"
            v-model="search"
            placeholder="Tìm kiếm theo tên"
            class="custom-input-search"
          />
        </template>
        <template slot-scope="scope">
          <el-button
            size="mini"
            @click="handleEdit(scope.$index, scope.row)"
            icon="el-icon-edit"
            >Sửa</el-button
          >
          <el-button
            size="mini"
            type="danger"
            icon="el-icon-delete"
            @click="handleDelete(scope.$index, scope.row)"
            >Xóa</el-button
          >
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      manufacturer: [],
      dialogFormAdd: false,
      addform: {
        name: "",
      },
      search: "",
      formLabelWidth: "120px",

      dialogFormEdit: false,
      editform: {
        id: null,
        name: "",
      },
    };
  },
  mounted() {
    this.getAllManufacturer();
  },
  methods: {
    getAllManufacturer() {
      axios
        .get("manufacturer")
        .then((result) => {
          this.manufacturer = result.data.data;
          console.log(this.manufacturer);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    handleSubmit() {
      this.dialogFormAdd = false;
      axios
        .post("manufacturer", this.addform)
        .then((result) => {
          console.log(result);
          this.$swal({
            icon: "success",
            title: "Thêm Hãng thành công",
            showConfirmButton: false,
          });
          this.getAllManufacturer();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    handleEdit(index, row) {
      this.dialogFormEdit = true;
      this.editform = row;
      console.log(index, row);
    },
    editManufacturer() {
      this.dialogFormEdit = false;
      this.$swal
        .fire({
          title: "Bạn muốn sửa?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Vâng tôi đồng ý",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .post("manufacturer", this.editform)
              .then((result) => {
                console.log(result);
                this.$swal({
                  icon: "success",
                  title: "Sửa Hãng Thành Công",
                  showConfirmButton: false,
                });
                this.getAllManufacturer();
              })
              .catch((err) => {
                console.log(err);
              });
          }
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
              .delete(`manufacturer/${row.id}`)
              .then(() => {
                swalWithBootstrapButtons.fire("Đã Xóa!", "", "success");
                this.getAllManufacturer();
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
  },
  computed: {},
};
</script>

<style>
.wrap-component {
  text-align: left;
}
.btn-add {
  margin-bottom: 20px !important;
}
.btn-margin {
  margin-left: 15px;
}
.custom-input-search {
  height: 28px;
  line-height: 28px;
  -webkit-appearance: none;
  background-color: #fff;
  background-image: none;
  border-radius: 4px;
  border: 1px solid #dcdfe6;
  box-sizing: border-box;
  color: #606266;
  display: inline-block;
  font-size: inherit;
  height: 40px;
  line-height: 40px;
  outline: 0;
  padding: 0 15px;
  transition: border-color 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);
  width: 100%;
}
</style>
