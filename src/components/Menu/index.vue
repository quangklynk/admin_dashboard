<template>
  <el-container style="height: 100vh">
    <el-aside
      width="256px"
      style="background-color: rgb(238, 241, 246)"
      class="slide-bar"
    >
      <Nav />
    </el-aside>
    <el-container class="custom-container-main">
      <el-header
        style="text-align: right; font-size: 12px"
        class="custom-header"
      >
        <el-dropdown>
          <!-- <div class="block"><el-avatar :size="50" :src="circleUrl"></el-avatar></div> -->
          <span class="account-login">Tài Khoản: {{ user }}</span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item>
              <i class="el-icon-user-solid"></i>
              <span @click="info_page">Thông tin cá nhân </span>
            </el-dropdown-item>
            <el-dropdown-item divided>
              <i class="el-icon-error"></i>
              <span @click="log_out">Đăng xuất</span>
            </el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
        <el-divider class="unset-margin"></el-divider>

        <el-breadcrumb separator="/" class="custom-breadcrumb">
          <el-breadcrumb-item v-for="route in $route.matched" :key="route.id">
            {{ route.meta.text }}
          </el-breadcrumb-item>
        </el-breadcrumb>
      </el-header>

      <el-main class="custom-main">
        <router-view />
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
import Nav from "./V_SlideBar.vue";
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  methods: {
    log_out() {
      this.$swal({
        icon: "info",
        title: "Đã đăng xuất",
        showConfirmButton: false,
      });
      axios
        .post("/logout")
        .then((result) => {
          console.log(result);
        })
        .catch((err) => {
          console.log(err);
        });
      localStorage.removeItem(`token`);
      localStorage.removeItem(`id`);
      localStorage.removeItem(`user`);
      localStorage.removeItem(`role`);
      this.$store.dispatch("id", "");
      this.$store.dispatch("user", "");
      this.$store.dispatch("role", "");
      this.$router.push("/");
    },
    info_page() {
      this.$router.push("/user");
    },
  },
  components: {
    Nav,
  },
  computed: {
    ...mapGetters(["user"]),
  },
};
</script>

<style scoped>
.custom-main {
  padding-top: 2rem;
}

.unset-margin {
  margin: unset !important;
}

.el-header {
  background-color: #b3c0d1;
  color: #333;
  line-height: 60px;
}

.custom-breadcrumb {
  padding: 0.75rem 1rem;
  font-size: 17px;
  font-weight: 400;
}

header.custom-header {
  height: unset !important;
  padding: unset !important;
  background-color: #fff;
  box-shadow: 0 2px 4px 0 rgb(0 0 0 / 12%), 0 -2px 2px 0 rgb(0 0 0 / 4%);
  border: 0;
}

.custom-container-main {
  background-color: #ebedef;
}

.el-aside {
  color: #333;
}
.slide-bar {
  text-align: left;
}

.account-login {
  font-size: 15px;
  font-weight: 600;
  margin-right: 20px;
}
</style>
