<template>
  <el-container style="height: 100vh">
    <el-aside style="background-color: rgb(238, 241, 246)">
      <h5 class="name-project">Chức năng</h5>
      <el-menu
        default-active="2"
        class="el-menu-vertical-demo"
        @open="handleOpen"
        @close="handleClose"
        background-color="#545c64"
        text-color="#fff"
        active-text-color="#ffd04b"
        ><router-link to="/test">
          <el-menu-item index="1">
            <i class="el-icon-menu"></i>
            <span>Tiêu đề 1</span>
          </el-menu-item>
        </router-link>
        <router-link to="/train">
          <el-menu-item index="2">
            <i class="el-icon-menu"></i>
            <span>Tiêu đề 2</span>
          </el-menu-item>
        </router-link>
      </el-menu>
    </el-aside>

    <el-container>
      <el-header> <p>Đề tài: </p> </el-header>

      <el-main>
        <router-view></router-view>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
export default {};
</script>

<style>
.el-header {
  background-color: #b3c0d1;
  color: #333;
  line-height: 60px;
}

.el-aside {
  color: #333;
}

.name-project {
  padding: 20px;
  text-align: center;
  font-size: 20px;
}
</style>