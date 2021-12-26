<template>
  <div class="container-edit-employee">
    <el-row :gutter="20">
      <el-col :span="12" class="container-form">
        <el-form
          :model="employee"
          :rules="rules"
          ref="employee"
          label-width="120px"
          class="demo-form.add"
        >
          <el-form-item label="Tên nhân viên: " prop="name">
            <el-input v-model="employee.name"></el-input>
          </el-form-item>
          <el-form-item label="Giới tính" prop="gender">
            <el-radio-group v-model="employee.gender">
              <el-radio label="1">Nam</el-radio>
              <el-radio label="0">Nữ</el-radio>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="Địa chỉ: " prop="address">
            <el-input type="textarea" v-model="employee.address"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('employee')"
              >Sửa</el-button
            >
            <el-button @click="resetForm('employee')">Reset</el-button>
          </el-form-item>
        </el-form></el-col
      >
      <el-col :span="8"><div class="grid-content bg-purple"></div></el-col>
    </el-row>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      employee: {},
      rules: {
        name: [
          {
            required: true,
            message: "Vui lòng nhập tên",
            trigger: "blur",
          },
        ],
        email: [
          {
            required: true,
            message: "Please select Activity zone",
            trigger: "change",
          },
        ],
        password: [
          {
            required: true,
            message: "Vui lòng nhập password",
            trigger: "blur",
          },
          {
            min: 8,
            max: 16,
            message: "Đồ dài 8 đến 16",
            trigger: "blur",
          },
        ],
        idRole: [
          {
            required: true,
            message: "Please select Activity zone",
            trigger: "change",
          },
        ],
        address: [
          {
            required: true,
            message: "Vui lòng nhập địa chỉ đang cư trú",
            trigger: "blur",
          },
        ],
      },
    };
  },
  mounted() {
    this.getEmployeeByID();
  },
  methods: {
    getEmployeeByID() {
      axios
        .get(`employee/${this.$route.params.id}`)
        .then((result) => {
          this.employee = result.data.data;
          this.employee.gender = this.employee.gender.toString();
        })
        .catch((err) => {
          this.$message({
            showClose: true,
            message: `Oops, ${err}.`,
            type: "error",
          });
        });
    },
    submitForm(formName) {
      console.log(this.employee);
      this.$refs[formName].validate((valid) => {
        if (valid) {
          axios
            .post("employee/updateinfo", this.employee)
            .then((result) => {
              console.log(result);
              this.$swal({
                icon: "success",
                title: "Sửa nhân viên thành công",
                showConfirmButton: false,
              });
              this.getEmployeeByID()
            })
            .catch((err) => {
              console.log(err);
              this.$message({
                type: "info",
                message: "Server lỗi!!!!",
              });
            });
        } else {
          this.$message({
            message: "Vui lòng điền đầy đủ thông tin.",
            type: "warning",
          });
          return false;
        }
      });
    },
    resetForm(formName) {
      this.$confirm("Bạn sẽ bỏ hết dữ liệu hiện tại?", "Cảnh bảo!!!", {
        confirmButtonText: "OK",
        cancelButtonText: "Hủy Bỏ",
        type: "warning",
      })
        .then(() => {
          this.$message({
            type: "success",
            message: "Bỏ thành công",
          });
          this.$refs[formName].resetFields();
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "Hủy bỏ",
          });
        });
    },
  },
};
</script>

<style>
.container-edit-employee {
  text-align: left;
}

.container-form {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
  padding: 20px 20px 0 20px;
  background: #fff;
  border-radius: 4px;
}
</style>
