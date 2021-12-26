<template>
  <div class="wrap-component">
    <!-- Form -->
    <el-button
      icon="el-icon-circle-plus-outline"
      class="btn-add"
      type="primary"
      @click="dialogFormAdd = true"
      >Thêm</el-button
    >

    <el-dialog title="Thêm NCC mới" :visible.sync="dialogFormAdd">
      <el-form :model="addform" :rules="rules" ref="addform">
        <el-form-item label="Tên NCC" prop="name" :label-width="formLabelWidth">
          <el-input v-model="addform.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item
          label="Địa Chỉ"
          prop="address"
          :label-width="formLabelWidth"
        >
          <el-input v-model="addform.address" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="Email" prop="email" :label-width="formLabelWidth">
          <el-input v-model="addform.email" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormAdd = false">Hủy Bỏ</el-button>
        <el-button type="primary" @click="handleSubmit('addform')"
          >Ghi</el-button
        >
      </span>
    </el-dialog>

    <!-- Sửa -->
    <el-dialog title="Chỉnh sửa NCC" :visible.sync="dialogFormEdit">
      <el-form :model="editform" :rules="rules" ref="editform">
        <el-form-item label="Tên NCC" prop="name" :label-width="formLabelWidth">
          <el-input v-model="editform.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item
          label="Địa Chỉ"
          prop="address"
          :label-width="formLabelWidth"
        >
          <el-input v-model="editform.address" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="Email" prop="email" :label-width="formLabelWidth">
          <el-input v-model="editform.email" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormEdit = false">Hủy Bỏ</el-button>
        <el-button type="primary" @click="editDistributor('editform')"
          >Ghi</el-button
        >
      </span>
    </el-dialog>

    <el-table :data="distributors" slot="empty" empty-text="Bảng Rỗng">
      <el-table-column prop="id" label="ID"> </el-table-column>
      <el-table-column prop="name" label="Tên Hãng"> </el-table-column>
      <el-table-column prop="address" label="Địa chỉ"> </el-table-column>
      <el-table-column prop="email" label="Email"> </el-table-column>
      <el-table-column label="Thao tác">
        <template slot-scope="scope">
          <el-button
            icon="el-icon-edit"
            size="mini"
            @click="handleEdit(scope.$index, scope.row)"
            >Sửa</el-button
          >
          <el-button
            icon="el-icon-delete"
            size="mini"
            type="danger"
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
      distributors: [],
      dialogFormAdd: false,
      addform: {
        name: "",
        address: "",
        email: "",
      },
      formLabelWidth: "120px",
      dialogFormEdit: false,
      editform: {
        id: null,
        name: "",
        address: "",
        email: "",
      },
      rules: {
        name: [
          {
            required: true,
            message: "Vui lòng nhập tên",
            trigger: "blur",
          },
        ],
        address: [
          {
            required: true,
            message: "Vui lòng nhập địa chỉ",
            trigger: "blur",
          },
        ],
        email: [
          {
            required: true,
            message: "Vui lòng nhập email",
            trigger: "blur",
          },
          {
            type: "email",
            message: "Vui lòng nhập đúng chuẩn email",
            trigger: "blur",
          },
        ],
      },
    };
  },
  mounted() {
    this.getAllDistributors();
  },
  methods: {
    getAllDistributors() {
      axios
        .get("distributor")
        .then((result) => {
          this.distributors = result.data.data;
          console.log(result);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    handleSubmit(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.dialogFormAdd = false;
          axios
            .post("distributor", this.addform)
            .then((result) => {
              console.log(result);
              this.$swal({
                icon: "success",
                title: "Thêm Hãng thành công",
                showConfirmButton: false,
              });
              this.getAllDistributors();
            })
            .catch((err) => {
              console.log(err);
              this.$swal({
                icon: "error",
                title: "Thêm hãng thất bại",
                showConfirmButton: false,
              });
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    handleEdit(index, row) {
      this.dialogFormEdit = true;
      this.editform = row;
      console.log(index, row);
    },
    editDistributor(formName) {
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
                  .post("distributor", this.editform)
                  .then((result) => {
                    console.log(result);
                    this.$swal({
                      icon: "success",
                      title: "Sửa NCC Thành Công",
                      showConfirmButton: false,
                    });
                    this.getAllDistributors();
                  })
                  .catch((err) => {
                    this.$swal({
                      icon: "error",
                      title: " NCC Thất Bại",
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
              .delete(`distributor/${row.id}`)
              .then((res) => {
                console.log(res)
                if (res.data.mess) {
                  swalWithBootstrapButtons.fire("Lỗi~~~", `${res.data.mess}`, "error");
                } else {
                  swalWithBootstrapButtons.fire("Đã Xóa!", "", "success");
                }
                this.getAllDistributors();
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

<style scoped>
.wrap-component {
  text-align: left;
}
.btn-add {
  margin-bottom: 20px !important;
}
.btn-margin {
  margin-left: 15px;
}
</style>
