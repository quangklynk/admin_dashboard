<template>
  <div class="container-employee">
    <router-link to="/menu/add_emp">
      <el-button type="primary">
        <span>Thêm Nhân Viên</span>
      </el-button>
    </router-link>

    <!-- Sửa hình nhân viên -->
    <el-dialog
      title="Sửa Ảnh Nhân Viên"
      :visible.sync="dialogVisible"
      width="30%"
    >
      <div class="wrapper-img">
        <img v-if="image_upload" :src="image_upload" alt="" />
        <i v-else class="el-icon-plus set-icon"></i>
        <input
          type="file"
          class="file-upload"
          ref="upload"
          @change="showImg"
          accept="image/jpeg"
        />
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="subimitEdit">Sửa</el-button>
      </span>
    </el-dialog>

    <el-empty
      v-if="data.employees.length == 0"
      description="Dữ liệu rỗng"
    ></el-empty>
    <div
      class="element-eml"
      v-for="employee in data.employees"
      :key="employee.id"
    >
      <el-row>
        <el-col :span="6"
          ><h4 class="none-block">Mã NV: {{ employee.id }}</h4>
          <el-button-group>
            <el-button
              type="primary"
              icon="el-icon-edit"
              size="mini"
              @click="handleEmployeeByID(employee.id)"
            ></el-button>
            <el-button
              type="warning"
              size="mini"
              icon="el-icon-picture-outline"
              @click="handleOpenEditImage(employee.id)"
            ></el-button>
            <el-button
              v-if="employee.flag == 1"
              @click="deleleEmployee(employee.email)"
              type="danger"
              size="mini"
              icon="el-icon-delete"
            ></el-button>
            <el-button
              v-else
              @click="backEmployee(employee.email)"
              type="info"
              size="mini"
              icon="el-icon-refresh-left"
            ></el-button>
          </el-button-group>
        </el-col>
      </el-row>

      <table class="steelBlueCols">
        <tbody>
          <tr>
            <td><i class="el-icon-user"></i> Tên:</td>
            <td class="name-emp">{{ employee.name }}</td>
            <td><i class="el-icon-chat-dot-square"></i> Email:</td>
            <td>{{ employee.email }}</td>
            <td><i class="el-icon-help"></i> Trạng thái:</td>
            <td>
              <el-popconfirm
                v-if="employee.flag == 1"
                confirm-button-text="OK"
                cancel-button-text="Không"
                icon="el-icon-info"
                icon-color="red"
                title="Bạn có muốn xóa"
                @confirm="deleleEmployee(employee.email)"
              >
                <el-button slot="reference" class="fix-heigh status-active"
                  >còn làm</el-button
                >
              </el-popconfirm>
              <el-popconfirm
                v-if="employee.flag == 0"
                confirm-button-text="OK"
                cancel-button-text="Không"
                icon="el-icon-info"
                icon-color="red"
                title="Bạn có muốn phục hồi"
                @confirm="backEmployee(employee.email)"
              >
                <el-button slot="reference" class="fix-heigh status-error"
                  >nghỉ làm</el-button
                >
              </el-popconfirm>
            </td>
            <td><i class="el-icon-help"></i> Hình ảnh:</td>
            <td>
              <el-popover placement="bottom" width="330" trigger="click">
                <img class="img-employee" :src="employee.image" alt="" />
                <el-button class="fix-heigh" type="primary" slot="reference"
                  >Xem ảnh</el-button
                >
              </el-popover>
            </td>
          </tr>
          <tr>
            <td><i class="el-icon-tickets"></i> Chức vụ:</td>
            <td>{{ employee.role_name }}</td>
            <td><i class="el-icon-location-outline"></i> Địa chỉ:</td>
            <td colspan="5">{{ employee.address }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Employee",
  data() {
    return {
      dialogVisible: false,
      image_upload: "",
      data: {
        employees: [],
      },
      defaut_path: "http://localhost/image/employee/",
      formImage: {
        id: "",
        image: "",
      },
    };
  },
  created() {
    this.getAllEmployees();
  },
  methods: {
    getAllEmployees() {
      axios
        .get("employee")
        .then((result) => {
          this.data.employees = result.data.data;
          this.data.employees.forEach((element) => {
            element.image = this.defaut_path + element.image;
          });
          console.log(result);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deleleEmployee(id) {
      axios
        .delete(`employee/${id}`)
        .then(() => {
          this.$swal.fire(
            "Đã khóa!",
            "Nhân viên này không thể đăng nhập.",
            "success"
          );
          this.getAllEmployees();
        })
        .catch((err) => {
          this.$swal.fire("Lỗi!", err, "success");
        });
    },

    backEmployee(id) {
      axios
        .get(`/employee/back/${id}`)
        .then(() => {
          this.$swal.fire(
            "Đã phục hồi!",
            "Nhân viên có thể đăng nhập.",
            "success"
          );
          this.getAllEmployees();
        })
        .catch((err) => {
          this.$swal.fire("Lỗi!", err, "success");
        });
    },

    handleEmployeeByID(id) {
      if (isNaN(id)) {
        this.$message({
          showClose: true,
          message: "Có gì đó sai sai.",
          type: "error",
        });
      } else {
        this.$router.push({ path: `/menu/employee/${id}` });
      }
    },

    // Sửa hình
    handleOpenEditImage(id) {
      this.formImage.id = id;
      this.dialogVisible = true;
    },
    showImg(e) {
      this.image_upload = URL.createObjectURL(e.target.files[0]);
      this.formImage.image = e.target.files[0];
    },
    subimitEdit() {
      if (!this.formImage.image || this.formImage.image == "") {
        this.$notify({
          title: "Cảnh báo",
          message: "Bạn chưa nhập hình ảnh",
          type: "warning",
          offset: 100,
        });
        return;
      }
      this.dialogVisible = false;
      let fd = new FormData();

      fd.append("image", this.formImage.image);
      fd.append("id", this.formImage.id);
      axios({
        method: "POST",
        url: "http://localhost/api/employee/updateimg",
        data: fd,
        headers: {
          "Content-Type": "multipart/form-data",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      })
        .then((result) => {
          console.log(result);

          this.$swal({
            icon: "success",
            title: "Sửa hình thành công",
            showConfirmButton: false,
          });
          this.image_upload = ""
          this.getAllEmployees();
        })
        .catch((err) => {
          this.$swal({
            icon: "error",
            title: "Sửa hình thất bại",
            text: err,
            showConfirmButton: false,
          });
        });
    },
  },
};
</script>

<style>
.container-employee {
  text-align: left;
}

.element-eml {
  text-align: left;
  padding: 15px 0;
}

table.steelBlueCols {
  border: 1px solid #ebeef5;
  background-color: #fafafa;
  width: 100%;
  height: 120px;
  text-align: center;
  border-collapse: collapse;
}
table.steelBlueCols td,
table.steelBlueCols th {
  border: 1px solid #ebeef5;
  padding: 8px 10px;
}
table.steelBlueCols tbody td {
  font-size: 12px;
  font-weight: bold;
  color: #909399;
}
table.steelBlueCols td:nth-child(odd) {
  width: 150px;
}
table.steelBlueCols td:nth-child(even) {
  background: #ffffff;
  width: fit-content;
}
table.steelBlueCols td.name-emp {
  width: 120px;
}

table.steelBlueCols tfoot td {
  font-size: 15px;
}
table.steelBlueCols tfoot .links {
  text-align: right;
}
table.steelBlueCols tfoot .links a {
  display: inline-block;
  background: #ffffff;
  color: #398aa4;
  padding: 2px 8px;
  border-radius: 5px;
}
.img-employee {
  width: 300px;
  height: 300px;
}

.fix-heigh {
  padding: 2px !important;
}

.status-error {
  background: #e55353 !important;
  color: #fff !important;
}

.status-active {
  background: #2eb85c !important;
  color: #fff !important;
}

.none-block {
  display: unset;
  padding-right: 10px;
}

.wrapper-img {
  height: 200px;
  width: 200px;
  position: relative;
  border: 2px dashed #d9d9d9;
  border-radius: 5px;
  overflow: hidden;
  z-index: 1;
  margin: 0 auto;
}

.wrapper-img .set-icon {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #fff;
}

.wrapper-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.file-upload {
  position: absolute;
  bottom: 0px;
  outline: none;
  color: transparent;
  width: 100%;
  height: 100%;
  box-sizing: border-box;
  cursor: pointer;
  transition: 0.5s;
  z-index: 2;
  display: block;
}

.file-upload::-webkit-file-upload-button {
  visibility: hidden;
}
</style>
