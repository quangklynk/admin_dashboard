<template>
  <div class="container-role" v-loading="event.loading">
    <el-row :gutter="2" class="row-action">
      <el-button
        type="primary"
        icon="el-icon-circle-plus-outline"
        @click="openDialogAdd"
        >Thêm</el-button
      >
      <el-button type="success" icon="el-icon-refresh-left" @click="getAllRole"
        >Reload</el-button
      >
    </el-row>
    <el-row :gutter="20">
      <el-col>
        <el-table
          empty-text="Bảng Rỗng"
          :data="data.roles"
          style="width: 500px"
        >
          <el-table-column label="ID" width="180">
            <template slot-scope="scope">
              <span style="margin-left: 10px">{{ scope.row.id }}</span>
            </template>
          </el-table-column>
          <el-table-column label="Tên quyền" width="180">
            <template slot-scope="scope">
              <div slot="reference" class="name-wrapper">
                <el-tag size="medium">{{ scope.row.role_name }}</el-tag>
              </div>
            </template>
          </el-table-column>
          <el-table-column label="Thao tác">
            <template slot-scope="scope">
              <el-button
                size="mini"
                @click="handleEdit(scope.$index, scope.row)"
                >Sửa</el-button
              >
              <el-button
                size="mini"
                type="danger"
                @click="handleDelete(scope.$index, scope.row)"
                >Xóa</el-button
              >
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>
    <el-dialog
      :title="data.titleDialog"
      :visible.sync="event.showDialog"
      width="30%"
      center
    >
      <el-form :model="form.add">
        <el-form-item label="Tên quyền: " label-width="120px">
          <el-input
            v-model="form.add.role_name"
            autocomplete="off"
          ></el-input> </el-form-item
      ></el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="cancleDialog">Hủy</el-button>
        <el-button type="primary" @click="handleAdd()">Thêm</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      data: {
        roles: [],
        titleDialog: "Thêm Quyền Mới",
      },
      form: {
        add: {
          role_name: "",
        },
        edit: {
          id: null,
          role_name: "",
        },
      },
      event: {
        loading: true,
        showDialog: false,
        status: "",
      },
    };
  },
  mounted() {
    this.getAllRole();
  },
  methods: {
    getAllRole() {
      this.event.loading = true;
      axios
        .get("role")
        .then((result) => {
          this.data.roles = result.data.data;
          this.event.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    handleEdit(index, row) {
      console.log(index, row);
      this.data.titleDialog = "Chỉnh sửa";
      this.form.edit.id = row.id;
      this.form.add.role_name = row.role_name;
      this.event.showDialog = true;
      this.event.status = "edit"
    },

    cancleDialog() {
      this.event.showDialog = false;
      this.form.add.role_name = "";
    },

    openDialogAdd() {
      this.form.add.role_name = "";
      this.event.showDialog = true;
      this.event.status = "add";
      this.data.titleDialog = "Thêm Quyền Mới";
    },

    handleAdd() {
      if (this.form.add.role_name == "") {
        this.$message({
          message: "Điền đầy đủ thông tin vào (๑•̀ㅂ•́)و",
          type: "warning",
        });
      } else {
        this.event.showDialog = false;
        if (this.event.status == "add") {
          axios
            .post("role", this.form.add)
            .then((result) => {
              if (result.status == "successful") {
                this.$swal({
                  icon: "success",
                  title: "Thêm trạng thái thành công (≧▽≦)",
                  showConfirmButton: false,
                  timer: 1500,
                });
                this.getAllRole();
              } else {
                this.$message.error(
                  `Oops, Lỗi~~~~, Không thêm được.(」゜ロ゜)」`
                );
              }
            })
            .catch((err) => {
              console.log(err);
            });
        } else {
          this.form.edit.role_name = this.form.add.role_name;
          axios
            .post("role", this.form.edit)
            .then((result) => {
              console.log(result);
              this.getAllRole();
              this.$swal({
                icon: "success",
                title: "Sửa Trạng Thái Thành Công (≧▽≦)",
                showConfirmButton: false,
              });
            })
            .catch((err) => {
              console.log(err);
            });
        }
        this.event.status = "";
      }
    },

    handleDelete(index, row) {
      console.log(index, row);
      this.$confirm("Quyền này sẽ xóa và không được phục hồi?", "Warning", {
        confirmButtonText: "OK",
        cancelButtonText: "Cancel",
        type: "warning",
      })
        .then(() => {
          axios
            .delete(`role/${row.id}`)
            .then((result) => {
              if (result.status == "successful") {
                this.$message({
                  type: "success",
                  message: "Đã xóa",
                });
                this.getAllRole();
              } else {
                this.$message.error(`Oops, Lỗi~~~~, Không xóa được.`);
              }
            })
            .catch((err) => {
              this.$message.error(`Oops, Lỗi~~~~, ${err}.`);
            });
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "Hủy xóa",
          });
        });
    },
  },
};
</script>

<style>
.container-role {
  text-align: left;
}

.row-action {
  margin-bottom: 20px;
  padding-left: 1px;
}
</style>
