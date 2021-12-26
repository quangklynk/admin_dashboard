<template>
  <el-header style="text-align: right; font-size: 12px" class="custom-header">
    <el-dropdown>
      <!-- <div class="block"><el-avatar :size="50" :src="circleUrl"></el-avatar></div> -->
      <span>Tom</span>
      <i class="el-icon-user-solid" style="margin-right: 15px"></i>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item>Thông tin cá nhân</el-dropdown-item>
        <el-dropdown-item divided>Đăng Xuất</el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>
    <el-divider class="unset-margin"></el-divider>

    <el-breadcrumb separator="/" class="custom-breadcrumb">
      <el-breadcrumb-item :to="{ path: '/' }">homepage</el-breadcrumb-item>
      <el-breadcrumb-item
        ><a href="/">promotion management</a></el-breadcrumb-item
      >
      <el-breadcrumb-item>promotion list</el-breadcrumb-item>
      <el-breadcrumb-item>promotion detail</el-breadcrumb-item>
    </el-breadcrumb>
  </el-header>
</template>

<script>
export default {};
</script>

<style scoped>
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
</style>
