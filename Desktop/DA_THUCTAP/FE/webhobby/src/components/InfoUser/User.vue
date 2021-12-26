<template>
  <div class="container-change-pass">
    <div class="title">
      <h3>Hồ Sơ Của Tôi</h3>
      <p>Chỉ được xem thông tin, thay đổi xin liên hệ admin</p>
    </div>
    <div class="form-user">
      <div class="form-info">
        <el-form label-position="right" label-width="100px" :model="info">
          <el-form-item label="Mã NV:">
            <label>{{ info.id }}</label>
          </el-form-item>
          <el-form-item label="Tên:">
            <label>{{ info.name }}</label>
          </el-form-item>
          <el-form-item label="Email:">
            <label>{{ info.email }}</label>
          </el-form-item>
          <el-form-item label="Địa chỉ:">
            <label>{{ info.address }}</label>
          </el-form-item>
          <el-form-item label="Giới tính:" class="last-child-el">
            <label v-if="info.gender == 1">Nam</label>
            <label v-else>Nữ</label>
          </el-form-item>
        </el-form>
      </div>
      <div class="img-user">
        <div class="profile-images">
          <img :src="image" id="upload-img" />
        </div>
        <p class="title-img">Ảnh Nhân Viên</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      info: {
        name: "",
        address: "",
        gender: "",
        img: "",
        email: "",
        id: "",
      },
      image: "http://localhost:83/WebTMDT/resource/imgs/find_user.png",
      defaut_path: "http://localhost/image/employee/",
    };
  },
  mounted() {
    this.getEmployeeByID();
  },
  methods: {
    getEmployeeByID() {
      axios
        .get(`employee/${this.$store.getters.id}`)
        .then((result) => {
          console.log(result)
          this.info = result.data.data;
          this.info.gender = this.info.gender.toString();
          this.image = this.defaut_path + this.info.image;
        })
        .catch((err) => {
          console.log(err);
        });
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

.container-change-pass .form-user {
  padding: 30px 0;
  display: flex;
  padding-bottom: unset;
}
.container-change-pass .form-user .form-info {
  flex-basis: 70%;
  padding: 10px;
}
.container-change-pass .form-user .img-user {
  flex-basis: 30%;
  border-left: 1px solid #948d8d;
}

.title h3 {
  font-size: 22px;
  font-weight: 600;
  color: #4a4a4a;
  padding: unset;
  margin: unset;
}

.title p {
  font-size: 16px;
  margin: unset;
  margin-top: 5px;
  font-weight: 400;
}

.profile-images {
  width: 150px;
  height: 150px;
  background: #fff;
  border-radius: 50%;
  overflow: hidden;
  margin-left: auto;
  margin-right: auto;
}

.profile-images img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.title-img {
  color: #606266;
}

.last-child-el {
  margin: unset !important;
}
</style>
