<template>
  <div>
    <div class="container-log">
      <div class="left-container">
        <div class="img-log">
          <img src="./../../assets/imgs/Login/banner.jpg" alt="" />
        </div>
      </div>
      <div class="right-container">
          <router-view></router-view>
      </div>
    </div>
  </div>
</template>



<style>
.container-log {
  display: flex;
  align-items: center;
  width: 100%;
  height: 100vh;
  background-color: #0c83a1;
}
.container-log .left-container,
.container-log .right-container {
  height: inherit;
  flex: 1;
}
.container-log .left-container {
  width: 100%;
  position: relative;
}
.container-log .left-container .img-log {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: inherit;
}
.container-log .left-container .img-log img {
  width: inherit;
}
.container-log .right-container {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
