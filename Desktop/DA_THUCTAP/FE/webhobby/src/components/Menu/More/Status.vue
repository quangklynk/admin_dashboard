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
    <el-dialog title="Thêm trạng thái mới" :visible.sync="dialogFormAdd">
      <el-form :model="addform" :rules="rules" ref="addform">
        <el-form-item
          label="Tên Trạng Thái"
          :label-width="formLabelWidth"
          prop="description"
        >
          <el-input v-model="addform.description" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="offFormAdd('addform')">Hủy Bỏ</el-button>
        <el-button type="primary" @click="handleSubmit('addform')"
          >Ghi</el-button
        >
      </span>
    </el-dialog>

    <!-- Sửa -->
    <el-dialog title="Chỉnh sửa trạng thái" :visible.sync="dialogFormEdit">
      <el-form :model="editform" :rules="rules" ref="editform">
        <el-form-item
          prop="description"
          label="Tên Trạng Thái"
          :label-width="formLabelWidth"
        >
          <el-input
            v-model="editform.description"
            autocomplete="off"
          ></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormEdit = false">Hủy Bỏ</el-button>
        <el-button type="primary" @click="editStatus('editform')"
          >Ghi</el-button
        >
      </span>
    </el-dialog>

    <el-table :data="statuses" slot="empty" empty-text="Bảng Rỗng">
      <el-table-column prop="id" label="ID"> </el-table-column>
      <el-table-column prop="description" label="Mô tả"> </el-table-column>
      <el-table-column label="Thao tác">
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
      statuses: [],
      dialogFormAdd: false,
      addform: {
        description: "",
      },
      formLabelWidth: "120px",
      dialogFormEdit: false,
      editform: {
        id: null,
        description: "",
      },
      rules: {
        description: [
          {
            required: true,
            message: "Vui lòng nhập mô tả",
            trigger: "blur",
          },
        ],
      },
    };
  },
  mounted() {
    this.getAllStatus();
  },
  methods: {
    getAllStatus() {
      axios
        .get("status")
        .then((result) => {
          this.statuses = result.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    handleSubmit(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          axios
            .post("status", this.addform)
            .then((result) => {
              console.log(result);
              this.dialogFormAdd = false;
              this.$swal({
                icon: "success",
                title: "Thêm trạng thái thành công",
                showConfirmButton: false,
              });
              this.getAllStatus();
            })
            .catch((err) => {
              console.log(err);
              this.$swal({
                icon: "error",
                title: "Thêm trạng thái lỗi",
                text: err,
                showConfirmButton: false,
              });
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    offFormAdd(formName) {
      this.$refs[formName].resetFields();
      this.dialogFormAdd = false;
    },

    handleEdit(index, row) {
      this.dialogFormEdit = true;
      this.editform = row;
    },
    editStatus(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
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
                  .post("status", this.editform)
                  .then((result) => {
                    console.log(result);
                    this.$swal({
                      icon: "success",
                      title: "Sửa Trạng Thái Thành Công",
                      showConfirmButton: false,
                    });
                    this.getAllStatus();
                  })
                  .catch((err) => {
                    console.log(err);
                    this.$swal({
                      icon: "error",
                      title: "Sửa Trạng Thái Lỗi",
                      text: err,
                      showConfirmButton: false,
                    });
                  });
              }
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    handleDelete(index, row) {
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
              .delete(`status/${row.id}`)
              .then((result) => {
                console.log(result);
                if (result.data.mess) {
                  swalWithBootstrapButtons.fire("Lỗi~~~", `${result.data.mess}`, "error");
                } else {
                  swalWithBootstrapButtons.fire("Đã Xóa!", "", "success");
                  this.getAllStatus();
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
