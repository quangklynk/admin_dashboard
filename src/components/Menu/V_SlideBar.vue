<template>
  <el-col class="wrapper-bar">
    <el-menu
      default-active="1"
      class="el-menu-vertical"
      @open="handleOpen"
      @close="handleClose"
      background-color="#303c54"
      text-color="#fff"
      active-text-color="#ffd04b"
    >
      <div class="name-web">
        <h5>GundamBienHoa.VN</h5>
      </div>
      <router-link to="/menu/">
        <el-menu-item index="1">
          <i class="el-icon-document"></i>Dasboard
        </el-menu-item>
      </router-link>
      <el-submenu index="2">
        <template slot="title">
          <i class="el-icon-notebook-1"></i>
          <span>Blog</span>
        </template>
        <el-menu-item-group>
          <router-link to="/menu/blog">
            <el-menu-item index="2-1">Tất cả Blog</el-menu-item>
          </router-link>
          <router-link to="/menu/add-blog">
            <el-menu-item index="2-2">Thêm Blog</el-menu-item>
          </router-link>
        </el-menu-item-group>
      </el-submenu>
      <el-submenu index="3">
        <template slot="title">
          <i class="el-icon-data-board"></i>
          <span>Slide</span>
        </template>
        <el-menu-item-group>
          <router-link to="/menu/slide">
            <el-menu-item index="3-1">Tất cả Slide</el-menu-item></router-link
          >
        </el-menu-item-group>
      </el-submenu>
      <el-submenu index="4">
        <template slot="title">
          <i class="el-icon-shopping-cart-full"></i>
          <span>Đơn hàng</span>
        </template>
        <el-menu-item-group>
          <router-link to="/menu/order">
            <el-menu-item index="4-1"
              >Tất cả Đơn hàng</el-menu-item
            ></router-link
          >
          <router-link to="/menu/add-blog">
            <el-menu-item index="4-2">Thêm Đơn hàng</el-menu-item></router-link
          >
        </el-menu-item-group>
      </el-submenu>
      <el-submenu index="5">
        <template slot="title">
          <i class="el-icon-receiving"></i>
          <span>Sản phẩm</span>
        </template>
        <el-menu-item-group>
          <router-link to="/menu/product">
            <el-menu-item index="5-1"
              >Tất cả Sản phẩm</el-menu-item
            ></router-link
          >
          <router-link to="/menu/add-product">
            <el-menu-item index="5-2">Thêm Sản phẩm</el-menu-item></router-link
          >
        </el-menu-item-group>
      </el-submenu>
      <router-link to="/menu/customer">
        <el-menu-item index="6">
          <i class="el-icon-user"></i>
          Khách hàng
        </el-menu-item>
      </router-link>
      <el-submenu index="7">
        <template slot="title">
          <i class="el-icon-menu"></i>
          Nhập hàng
        </template>
        <el-menu-item-group>
          <router-link to="/menu/import-product">
            <el-menu-item index="7-1"
              >Phiếu nhập hàng</el-menu-item
            ></router-link
          >
          <router-link to="/menu/aimport-product">
            <el-menu-item index="7-2">Nhập hàng</el-menu-item></router-link
          >
        </el-menu-item-group>
      </el-submenu>
      <router-link to="/menu/employee">
        <el-menu-item index="8">
          <i class="el-icon-s-custom"></i>
          Nhân viên
        </el-menu-item>
      </router-link>
      <el-submenu index="9">
        <template slot="title">
          <i class="el-icon-thumb"></i>
          <span>Khác</span>
        </template>
        <el-menu-item-group>
          <router-link to="/menu/category">
            <el-menu-item index="9-1"
              >Tất cả Loại Sản Phẩm</el-menu-item
            ></router-link
          >
          <router-link to="/menu/distributor">
            <el-menu-item index="9-2">Tất cả NCC</el-menu-item></router-link
          >
          <router-link to="/menu/status">
            <el-menu-item index="9-3"
              >Tất cả Trạng Thái</el-menu-item
            ></router-link
          >

          <router-link to="/menu/role">
            <el-menu-item index="9-5">Tất cả quyền</el-menu-item></router-link
          >
        </el-menu-item-group>
      </el-submenu>
    </el-menu>
  </el-col>
</template>

<script>
export default {
  name: "Menubar",
  methods: {
    handleOpen(key, keyPath) {
      console.log(key, keyPath);
    },
    handleClose(key, keyPath) {
      console.log(key, keyPath);
    },
  },
};
</script>

<style scoped>
.name-web {
  text-align: center;
  padding: 25px 15px;
  color: #fff;
  background-color: #3c4b64;
}

.name-web h5 {
  margin: unset;
}

.el-menu-vertical {
  height: 100vh;
}
.el-menu-item.is-active {
  background-color: hsla(0, 0%, 100%, 0.05);
}

a {
  color: #fff;
}

a:active,
a:focus,
a:hover {
  color: #ffd04b;
}
</style>
