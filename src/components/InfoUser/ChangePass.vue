<template>
  <div class="container-change-pass">
    <div class="title">
      <h3>Đổi Mật Khẩu</h3>
    </div>
    <div class="form">
      <el-form
        :model="ruleForm"
        status-icon
        :rules="rules"
        ref="ruleForm"
        label-width="120px"
        class="demo-ruleForm"
      >
        <el-form-item label="Mật Khẩu Cũ" prop="old_pass">
          <el-input
            type="password"
            v-model="ruleForm.passold"
            autocomplete="off"
          ></el-input>
        </el-form-item>
        <el-form-item label="Mật Khẩu Mới" prop="passnew">
          <el-input
            type="password"
            v-model="ruleForm.passnew"
            autocomplete="off"
          ></el-input>
        </el-form-item>
        <el-form-item label="Xác Nhận" prop="checkPass">
          <el-input
            type="password"
            v-model="ruleForm.checkPass"
            autocomplete="off"
          ></el-input>
        </el-form-item>

        <el-form-item>
          <el-button
            type="primary"
            @click="submitForm('ruleForm')"
            icon="el-icon-thumb"
          >
            Đổi Mật Khẩu</el-button
          >
          <el-button @click="resetForm('ruleForm')">Reset</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    var validateOldPass = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("Nhập Mật Khẩu Cũ"));
      } else {
        if (this.ruleForm.checkPass !== "") {
          this.$refs.ruleForm.validateField("checkPass");
        }
        callback();
      }
    };
    var validatePass = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("Nhập Mật Khẩu Mới"));
      } else {
        if (this.ruleForm.checkPass !== "") {
          this.$refs.ruleForm.validateField("checkPass");
        }
        callback();
      }
    };
    var validatePass2 = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("Vui Lòng Xác Nhận Mật Khẩu"));
      } else if (value !== this.ruleForm.passnew) {
        callback(new Error("Không Khớp!!!"));
      } else {
        callback();
      }
    };
    return {
      ruleForm: {
        id: this.$store.getters.id,
        passnew: "",
        checkPass: "",
        passold: "",
      },
      rules: {
        passnew: [{ validator: validatePass, trigger: "blur" }],
        checkPass: [{ validator: validatePass2, trigger: "blur" }],
        old_pass: [{ validator: validateOldPass, trigger: "blur" }],
      },
    };
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          axios
            .post("change", this.ruleForm)
            .then((result) => {
              console.log(result);
              this.$notify({
                title: "Success",
                message: "Đổi Mật Khẩu Thành Công",
                type: "success",
                offset: 100,
              });
            })
            .catch((err) => {
              console.log(err);
            });
        } else {
          this.$notify({
            title: "Warning",
            message: "Nhập Đầy Đủ Thông Tin",
            type: "warning",
            offset: 100,
          });
          return false;
        }
      });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    },
  },
};
</script>

<style>
.container-change-pass {
  background: #fff;
  padding: 20px;
  width: 65%;
  margin: auto;
  font-size: 16px;
  font-weight: 600;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
}

.container-change-pass .title {
  padding: 30px 15px;
  border-bottom: 1px solid #948d8d;
  text-align: left;
}

.container-change-pass .form {
  padding: 30px 0;
}

.title h3 {
  font-size: 22px;
  font-weight: 600;
  color: #4a4a4a;
  padding: unset;
  margin: unset;
}

.el-form-item__content {
  text-align: left;
}
</style>
