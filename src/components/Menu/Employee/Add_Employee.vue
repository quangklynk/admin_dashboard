<template>
  <div class="container-add-emp">
    <el-form
      :model="form.add"
      :rules="rules"
      ref="form.add"
      label-width="120px"
      class="demo-form.add"
    >
      <el-form-item label="Tên nhân viên: " prop="name">
        <el-input v-model="form.add.name"></el-input>
      </el-form-item>
      <el-form-item label="Email: " prop="email">
        <el-input v-model="form.add.email"></el-input>
      </el-form-item>
      <el-form-item label="Password: " prop="password">
        <el-input
          placeholder="Please input password"
          v-model="form.add.password"
          show-password
        ></el-input>
      </el-form-item>
      <el-form-item label="Chức vụ" prop="idRole">
        <el-select v-model="form.add.idRole" placeholder="Phân quyền">
          <el-option
            v-for="item in data.roles"
            :key="item.id"
            :label="item.role_name"
            :value="item.id"
          >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="Giới tính" prop="gender">
        <el-radio-group v-model="form.add.gender">
          <el-radio label="1">Nam</el-radio>
          <el-radio label="0">Nữ</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="Địa chỉ: " prop="address">
        <el-input type="textarea" v-model="form.add.address"></el-input>
      </el-form-item>
      <el-form-item label="Hình ảnh: " prop="image">
        <input type="file" name="" id="" @change="handlePreview" />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="submitForm('form.add')"
          >Tạo</el-button
        >
        <el-button @click="resetForm('form.add')">Reset</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    // var validatePhone = (rule, value, callback) => {
    //   const regex_phone = /(0[3|5|7|8|9])+([0-9]{8})\b/g;
    //   if (!value.match(regex_phone)) {
    //     callback(new Error("Please input the Phone"));
    //   } else {
    //     callback();
    //   }
    // };

    return {
      form: {
        add: {
          name: "",
          email: "",
          password: "",
          gender: "0",
          address: "",
          image: "",
          idRole: null,
        },
      },
      data: {
        roles: [],
      },
      rules: {
        name: [
          {
            required: true,
            message: "Vui lòng nhập tên",
            trigger: "blur",
          }
        ],
        email: [
          {
            required: true,
            message: "Vui lòng nhập email",
            trigger: "change",
          },
          {
            type: "email",
            message: "Vui lòng nhập đúng chuẩn email",
            trigger: "blur",
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
            message: "Chọn quyền cho nhân viên",
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
    this.getAllRole();
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let fd = new FormData();

          fd.append("name", this.form.add.name);
          fd.append("email", this.form.add.email);
          fd.append("password", this.form.add.password);
          fd.append("address", this.form.add.address);
          fd.append("gender", this.form.add.gender);
          fd.append("image", this.form.add.image);
          fd.append("idRole", this.form.add.idRole);

          axios({
            method: "POST",
            url: "http://localhost/api/register",
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
                title: "Thêm nhân viên thành công",
                showConfirmButton: false,
              });
              this.$refs[formName].resetFields();
            })
            .catch((err) => {
              console.log(err.message);
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    },
    handlePreview(e) {
      this.form.add.image = e.target.files[0];
    },
    getAllRole() {
      axios
        .get("role")
        .then((result) => {
          this.data.roles = result.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style>
.container-add-emp {
  text-align: left;
}
</style>
