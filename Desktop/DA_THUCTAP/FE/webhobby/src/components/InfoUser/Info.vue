<template>
  <el-container class="container-menu-user">
    <el-header class="container-header-menu">
      <header class="container-header">
        <div class="back-menu" @click="back_menu">
          <i class="el-icon-back"></i> Back
        </div>
        <div class="title-header">Thông tin User</div>
      </header>
    </el-header>
    <el-container>
      <el-aside class="side-bar">
        <div class="block flex-box">
          <el-avatar
            :size="50"
            src="http://localhost:83/WebTMDT/resource/imgs/find_user.png"
          ></el-avatar>
          <span class="name-info"
            >Tài khoản của
            <p class="name-login">{{ user }}</p>
          </span>
        </div>
        <el-divider></el-divider>
        <el-menu default-active="1" class="el-menu-vertical-demo">
          <router-link to="/user/">
            <el-menu-item index="1">
              <i class="far fa-file-alt circle-icon"></i>
              <span class="site-menu">Thông tin cá nhân</span>
            </el-menu-item>
          </router-link>
          <router-link to="/user/changepass">
            <el-menu-item index="2">
              <i class="fas fa-key circle-icon"></i>
              <span class="site-menu">Đổi mật khẩu</span>
            </el-menu-item>
          </router-link>
        </el-menu>
      </el-aside>
      <el-main class="container-main-user">
        <router-view />
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {};
  },
  methods: {
    back_menu() {
      this.$router.push("/menu/");
    },
  },
  computed: {
    ...mapGetters(["user"]),
  },
};
</script>

<style>
.container-main-user {
  background: #f4f4f4;
}

.container-menu-user {
  height: 100vh;
}

.container-header {
  display: flex;
  align-items: center;
  height: 85px;
  background: #2f8dd2;
  font-size: 18px;
  padding: 20px;
  font-weight: 600;
  color: #fff;
}

.back-menu {
  padding-right: 15px;
  cursor: pointer;
}

.title-header {
  border-left: 2px solid #fff;
  padding-left: 15px;
}

.container-header-menu {
  height: 85px !important;
  padding: unset !important;
}

.side-bar {
  text-align: left;
  flex-basis: 18%;
}

.name-login {
  font-weight: bold;
  font-size: 18px;
  display: unset;
}

.flex-box {
  display: flex;
  justify-content: center;
  padding-top: 15px;
  width: 195px;
}

.name-info {
  display: flex;
  flex-direction: column;
}

.circle-icon {
  width: 30px;
  padding: 7px;
  text-align: center;
  text-decoration: none;
  border-radius: 50%;
}

.fa-key {
  background-color: #ee4d2d !important;
  color: #fff !important;
}

.fa-file-alt {
  background-color: #99d7ff !important;
  color: #fff !important;
}

.el-divider--horizontal {
  margin: unset !important;
}

.site-menu {
  color: #4a4a4a;
  padding-left: 5px;
  font-size: 15px;
  font-weight: 500;
}
</style>
