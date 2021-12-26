<template>
  <div class="content-login">
    <div class="form-acc">
      <form id="form-login" @submit.prevent="handleSubmit()">
        <div class="item-form">
          <h1>Đăng Nhập Kênh Quản Trị</h1>
        </div>
        <div class="item-form img-logo">
          <img src="./../../assets/imgs/Login/logo.png" alt="" />
        </div>
        <div class="item-form">
          <i class="fas fa-envelope icon"></i>
          <input
            name="email"
            type="email"
            v-model="user.email"
            placeholder="Nhập email"
          />
        </div>
        <div class="item-form">
          <i class="fas fa-lock icon"></i>
          <input
            :type="passwordFieldType"
            name="password"
            v-model="user.password"
            placeholder="Nhập mật khẩu"
          />
          <i
            class="fas fa-eye icon pass-icon"
            id="show-pass-login"
            @click="showPass()"
          ></i>
          <!-- <i
                  class="fas fa-eye-slash pass-icon"
                  id="hide-pass-login"
                  style="display: none"
                ></i> -->
        </div>
        <div class="item-form">
          <el-button
            v-if="loadingBtn"
            type="primary"
            :loading="true"
            class="btn"
            id="btn-login"
          >
            Đăng Nhập</el-button
          >
          <el-button
            v-else
            type="primary"
            :loading="false"
            class="btn"
            id="btn-login"
            native-type="submit"
          >
            Đăng Nhập</el-button
          >
        </div>
        <div class="item-form">
          <a href="#" class="forgot-pass" @click="forgot">Quên mật khẩu</a>
        </div>
        <div class="or">
          <div></div>
          <span>Hoặc</span>
          <div></div>
        </div>
        <div class="sign-up-link">
          <p>
            Đi đến
            <a id="btn-open-register" href="http://localhost:83/webTMDT/"
              ><span>Trang Web Chính!</span></a
            >
          </p>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Login",
  data() {
    return {
      user: {
        email: "",
        password: "",
      },
      loadingBtn: false,
      passwordFieldType: "password",
    };
  },
  methods: {
    forgot() {
      this.$router.push({ path: "/forgot" });
    },
    handleSubmit() {
      this.loadingBtn = true;
      axios
        .post("login", this.user)
        .then((result) => {
          console.log(result);
          if (result.data.email) {
            this.$swal({
              icon: "error",
              title: "Đăng nhập không thành công!!!",
              text: result.data.email,
              showConfirmButton: false,
            });
          }

          if (result.data.data.flag == 1) {
            localStorage.setItem("token", result.data.token);
            this.$swal({
              icon: "success",
              title: "Đăng nhập thành công!!!",
              showConfirmButton: false,
            });
            this.$store.dispatch("id", result.data.data.id);
            this.$store.dispatch("user", result.data.data.name);
            this.$store.dispatch("role", result.data.data.idRole);
            localStorage.setItem("id", result.data.data.id);
            localStorage.setItem("user", result.data.data.name);
            localStorage.setItem("role", result.data.data.role_name);
            this.$router.push({ path: "/menu" });
          } else {
            this.$swal({
              icon: "error",
              title: "Tài khoản đã bị khóa",
              showConfirmButton: false,
            });
          }
        })
        .catch((err) => {
          console.log(err);
          this.loadingBtn = false;
        });
    },

    showPass() {
      this.passwordFieldType =
        this.passwordFieldType === "password" ? "text" : "password";
    },
  },
};
</script>

<style scoped>
.content-login .form-acc {
  border-radius: 4px;
  -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
  -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
  margin: 0px auto;
  width: 400px;
  background: #fff;
}
.content-login .form-acc form .img-logo {
  display: flex;
  height: 120px;
  align-items: center;
  justify-content: center;
}
.content-login .form-acc form .item-form {
  width: 100%;
  padding: 10px 30px;
  position: relative;
}
.content-login .form-acc form .item-form h1 {
  font-size: 24px;
  font-weight: 500;
  color: #000;
  text-align: center;
  font-weight: 600;
}
.content-login .form-acc form .item-form input,
.content-login .form-acc form .item-form textarea {
  width: 100%;
  padding: 12px 10px;
  padding-left: 40px;
  display: inline-block;
  border: none;
  border-radius: 4px;
  box-sizing: border-box;
  cursor: text;
  outline: none;
  font-size: 16px;
  font-weight: 400;
  color: #495057;
  background-color: #cccc;
  background-clip: padding-box;
}
.content-login .form-acc form .item-form .btn {
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

.content-login .form-acc form .item-form .error-input {
  background-color: #f4bfbf !important;
}

.content-login .form-acc form .item-form .btn:hover {
  opacity: 0.8;
}
.content-login .form-acc form .or {
  display: flex;
  align-items: center;
  padding: 10px 0px;
}
.content-login .form-acc form .or div {
  height: 1px;
  width: 100%;
  background-color: #dbdbdb;
  -webkit-box-flex: 1;
}
.content-login .form-acc form .or span {
  color: #ccc;
  padding: 0 1rem;
  text-transform: uppercase;
  font-size: 14px;
}
.content-login .form-acc form .sign-up-link {
  padding: 10px;
  color: rgba(0, 0, 0, 0.26);
  text-align: center;
}
.content-login .form-acc form .sign-up-link p {
  font-size: 14px;
}

.content-login .form-acc form .sign-up-link p span {
  color: darkblue;
  font-weight: 600;
}

.item-form i.icon {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  left: 42px;
}

.item-form i.pass-icon {
  left: unset;
  right: 45px;
}

/*# sourceMappingURL=log-new.css.map */
</style>