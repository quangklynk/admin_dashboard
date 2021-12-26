<template>
  <div class="wrapp-form">
    <form @submit.prevent="submitForgot" action="">
      <div class="item-form">
        <h1>Reset Mật Khẩu</h1>
      </div>
      <div class="item-form">
        <i class="fas fa-lock"></i>
        <input
          type="password"
          name="password"
          placeholder="Nhập mật khẩu"
          v-model="form.password"
          autocomplete="off"
        />
      </div>
      <div class="item-form">
        <i class="fas fa-lock"></i>
        <input
          type="password"
          name="password"
          placeholder="Xác nhận mật khẩu"
          v-model="form.checkpass"
          autocomplete="off"
        />
      </div>
      <div class="item-form">
        <button class="btn" type="submit" id="btn-login">
          Đổi Mật Khẩu
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Forgot",
  data() {
    return {
      form: {
        token: localStorage.getItem("token"),
        password: "",
        checkpass: "",
      },
    };
  },
  methods: {
    login() {
      this.$router.push({ path: "/login" });
    },
    submitForgot() {
      if (this.form.password === "" || this.form.checkpass === "") {
        this.$message({
          message: "Cảnh báo, Nhập mật khẩu và xác nhận đầy đủ.",
          type: "warning",
        });
        return;
      }

      if (this.form.password !== this.form.checkpass) {
        this.$message({
          message: "Cảnh báo, Mật khẩu và xác nhận không khớp.",
          type: "warning",
        });
        return;
      }

      axios
        .post("/reset", this.form)
        .then((result) => {
          this.$swal({
            icon: "success",
            title: "Reset mật khẩu thành công!!!",
            showConfirmButton: false,
          });
          console.log(result)
        })
        .catch((err) => {
          this.$swal({
            icon: "error",
            title: "Lỗi!!!",
            text: `${err}`,
            showConfirmButton: false,
          });
        });
    },
  },
};
</script>

<style scoped>
.wrapp-form {
  width: 400px;
  background: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
  border-radius: 4px;
  height: fit-content;
  align-self: center;
}

form .item-form {
  width: 100%;
  padding: 10px 30px;
  position: relative;
}
form .item-form input,
form .item-form textarea {
  width: 100%;
  padding: 12px 10px;
  padding-left: 40px;
  display: inline-block;
  border: none;
  border-radius: 4px;
  box-sizing: border-box;
  cursor: text;
  outline: none;
  font-size: 1rem;
  font-weight: 400;
  color: #495057;
  background-color: #cccc;
  background-clip: padding-box;
}
form .item-form .btn {
  background-color: #30698c;
  color: white;
  height: 50px;
  font-weight: 600;
  font-size: 18px;
  padding: 10px;
  text-align: center;
  display: block;
  width: 100%;
  border-radius: 4px;
}

form .item-form .btn:hover {
  opacity: 0.8;
}

.item-form i {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  left: 42px;
}
</style>
