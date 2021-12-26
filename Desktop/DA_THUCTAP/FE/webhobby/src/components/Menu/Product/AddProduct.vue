<template>
  <el-form
    :model="ruleForm"
    :rules="rules"
    ref="ruleForm"
    label-width="120px"
    class="demo-ruleForm"
  >
    <div class="wrapp-panel">
      <!-- thông tin cơ bản, tên, mô tả  -->
      <h5>Thông tin cơ bản</h5>
      <el-form-item label="Tên SP" prop="name">
        <el-input v-model="ruleForm.name"></el-input>
      </el-form-item>
      <el-form-item label="Mô tả" prop="description">
        <el-input
          type="textarea"
          :autosize="{ minRows: 4, maxRows: 8 }"
          v-model="ruleForm.description"
        ></el-input>
      </el-form-item>
    </div>

    <div class="wrapp-panel">
      <!-- thông tin hình ảnh  -->
      <h5>Thông tin hình ảnh</h5>
      <el-form-item label="Hình ảnh" required>
        <div class="container-img-upload">
          <div class="wrapper-img">
            <img
              v-if="list_image_upload.imgAvatar"
              :src="list_image_upload.imgAvatar"
              alt=""
            />
            <i v-else class="el-icon-plus set-icon"></i>
            <input
              type="file"
              class="file-upload"
              ref="upload"
              @change="showImgA"
              accept="image/jpeg"
            />
            <span class="name-img">*Avatar</span>
          </div>
          <div class="wrapper-img">
            <img
              v-if="list_image_upload.img1"
              :src="list_image_upload.img1"
              alt=""
            />
            <i v-else class="el-icon-plus set-icon"></i>
            <input
              type="file"
              class="file-upload"
              ref="upload"
              @change="showImg1"
              accept="image/jpeg"
            />
            <span class="name-img">Hình ảnh 1</span>
          </div>
          <div class="wrapper-img">
            <img
              v-if="list_image_upload.img2"
              :src="list_image_upload.img2"
              alt=""
            />
            <i v-else class="el-icon-plus set-icon"></i>
            <input
              type="file"
              class="file-upload"
              ref="upload"
              @change="showImg2"
              accept="image/jpeg"
            />
            <span class="name-img">Hình ảnh 2</span>
          </div>
          <div class="wrapper-img">
            <img
              v-if="list_image_upload.img3"
              :src="list_image_upload.img3"
              alt=""
            />
            <i v-else class="el-icon-plus set-icon"></i>
            <input
              type="file"
              class="file-upload"
              ref="upload"
              @change="showImg3"
              accept="image/jpeg"
            />
            <span class="name-img">Hình ảnh 3</span>
          </div>
          <div class="wrapper-img">
            <img
              v-if="list_image_upload.img4"
              :src="list_image_upload.img4"
              alt=""
            />
            <i v-else class="el-icon-plus set-icon"></i>
            <input
              type="file"
              class="file-upload"
              ref="upload"
              @change="showImg4"
              accept="image/jpeg"
            />
            <span class="name-img">Hình ảnh 4</span>
          </div>
        </div>
      </el-form-item>
    </div>

    <div class="wrapp-panel">
      <!-- thông tin loại  -->
      <h5>Thông tin loại</h5>
      <el-form-item label="Loại sản phẩm" prop="idCategory">
        <el-select
          v-model="ruleForm.idCategory"
          clearable
          placeholder="Chọn loại"
        >
          <el-option
            v-for="item in data.category"
            :key="item.id"
            :label="item.name"
            :value="item.id"
          >
            <span style="float: left">{{ item.id + '-' + item.name }}</span>
            <span style="float: right; color: #8492a6; font-size: 13px"
              >NCC: {{ item.idDistributor }}</span
            >
          </el-option>
        </el-select>
      </el-form-item>
    </div>

    <div class="wrapp-panel">
      <!-- thông tin bán hàng, giá, kho, khuyến mãi  -->
      <h5>Thông tin bán hàng</h5>
      <el-form-item label="Giá" prop="price">
        <el-input v-model.number="ruleForm.price">
          <template slot="prepend">đ</template>
        </el-input>
      </el-form-item>
      <el-form-item label="Số Lượng" prop="unit">
        <el-input v-model.number="ruleForm.unit">
          <template slot="append">đơn vị</template>
        </el-input>
      </el-form-item>
      <el-form-item label="Khuyến mãi" prop="discount">
        <el-input v-model.number="ruleForm.discount">
          <template slot="append">%</template>
        </el-input>
      </el-form-item>
    </div>

    <div class="wrapp-panel">
      <h5>Thông tin khác</h5>
      <!-- thông tin khác ưu tiên xuất hiện  -->
      <el-form-item label="Ưu tiên xuất hiện" prop="remark">
        <el-radio-group v-model="ruleForm.remark">
          <el-radio label="1">Có</el-radio>
          <el-radio label="0">Không</el-radio>
        </el-radio-group>
      </el-form-item>
    </div>
    <el-form-item>
      <el-button type="primary" @click="submitForm('ruleForm')">Tạo</el-button>
      <el-button @click="resetForm('ruleForm')">Reset</el-button>
    </el-form-item>
  </el-form>
</template>
<script>
import axios from "axios";
export default {
  data() {
    var checkDiscount = (rule, value, callback) => {
      if (!Number.isInteger(value)) {
        callback(new Error("Vui lòng nhập số"));
      } else {
        if (value < 0) {
          callback(new Error("Khuyến mãi lớn hơn 0"));
        } else if (value > 100) {
          callback(new Error("Khuyến mãi bé hơn 100"));
        } else {
          callback();
        }
      }
    };
    var checkNummber = (rule, value, callback) => {
      if (!Number.isInteger(value)) {
        callback(new Error("Vui lòng nhập số"));
      } else {
        if (value <= 0) {
          callback(new Error("Vui lòng nhập lớn hơn 0"));
        } else {
          callback();
        }
      }
    };
    return {
      data: {
        category: [],
      },
      list_image_upload: {
        imgAvatar: "",
        img1: "",
        img2: "",
        img3: "",
        img4: "",
      },
      ruleForm: {
        name: "",
        price: "",
        discount: "",
        unit: "",
        description: "",
        remark: "0",
        idCategory: "",
        imgAvatar: "",
      },
      rules: {
        name: [
          {
            required: true,
            message: "Vui lòng nhập tên",
            trigger: "blur",
          },
          {
            min: 3,
            message: "Chiều dài < 3",
            trigger: "blur",
          },
        ],
        description: [
          {
            required: true,
            message: "Vui lòng nhập mô tả",
            trigger: "blur",
          },
          {
            min: 100,
            max: 3000,
            message: "Chiều dài 100 -> 3000",
            trigger: "blur",
          },
        ],
        discount: [
          {
            required: true,
            message: "Vui lòng nhập khuyến mãi",
            trigger: "blur",
          },
          { validator: checkDiscount, trigger: "blur" },
        ],
        price: [
          {
            required: true,
            message: "Vui lòng nhập giá",
            trigger: "blur",
          },
          { validator: checkNummber, trigger: "blur" },
        ],
        unit: [
          {
            required: true,
            message: "Vui lòng nhập số lượng",
            trigger: "blur",
          },
          { validator: checkNummber, trigger: "blur" },
        ],
        idCategory: [
          { required: true, message: "Chọn loại sản phẩm", trigger: "change" },
        ],
      },
    };
  },
  async created() {
    this.getAllCategory();
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          if (!this.ruleForm.imgAvatar) {
            this.$message({
              message: "Chưa điền Avatar(๑•̀ㅂ•́)و",
              type: "warning",
            });
            return;
          }
          let fd = new FormData();
          fd.append("name", this.ruleForm.name);
          fd.append("price", this.ruleForm.price);
          fd.append("discount", this.ruleForm.discount);
          fd.append("unit", this.ruleForm.unit);
          fd.append("description", this.ruleForm.description);
          fd.append("remark", this.ruleForm.remark);
          fd.append("idCategory", this.ruleForm.idCategory);
          fd.append("imgAvatar", this.ruleForm.imgAvatar);
          if (this.ruleForm.img1) {
            fd.append("img1", this.ruleForm.img1);
          }
          if (this.ruleForm.img2) {
            fd.append("img2", this.ruleForm.img2);
          }
          if (this.ruleForm.img3) {
            fd.append("img3", this.ruleForm.img3);
          }
          if (this.ruleForm.img4) {
            fd.append("img4", this.ruleForm.img4);
          }

          axios({
            method: "POST",
            url: "http://localhost/api/product",
            data: fd,
            headers: {
              "Content-Type": "multipart/form-data",
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          })
            .then((result) => {
              console.log(result);
              this.$swal({
                icon: "success",
                title: "Thêm sản phẩm thành công",
                showConfirmButton: false,
              });
              this.resetForm(formName);
              this.list_image_upload.imgAvatar = "";
              this.list_image_upload.img1 = "";
              this.list_image_upload.img2 = "";
              this.list_image_upload.img3 = "";
              this.list_image_upload.img4 = "";
            })
            .catch((err) => {
              console.log(err.message);
              this.$swal({
                icon: "error",
                title: "Thêm sản phẩm lỗi",
                text: err.message,
                showConfirmButton: false,
              });
            });
        } else {
          this.$message({
            message: "Bạn chưa nhập đủ",
            type: "warning",
          });
          return false;
        }
      });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    },
    showImgA(e) {
      console.log(e);
      this.list_image_upload.imgAvatar = URL.createObjectURL(e.target.files[0]);
      this.ruleForm.imgAvatar = e.target.files[0];
    },
    showImg1(e) {
      console.log(e);
      this.list_image_upload.img1 = URL.createObjectURL(e.target.files[0]);
      this.ruleForm.img1 = e.target.files[0];
    },
    showImg2(e) {
      console.log(e);
      this.list_image_upload.img2 = URL.createObjectURL(e.target.files[0]);
      this.ruleForm.img2 = e.target.files[0];
    },
    showImg3(e) {
      console.log(e);
      this.list_image_upload.img3 = URL.createObjectURL(e.target.files[0]);
      this.ruleForm.img3 = e.target.files[0];
    },
    showImg4(e) {
      console.log(e);
      this.list_image_upload.img4 = URL.createObjectURL(e.target.files[0]);
      this.ruleForm.img4 = e.target.files[0];
    },
    getAllCategory() {
      axios
        .get("category")
        .then((result) => {
          this.data.category = result.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style scoped>
.wrapp-panel {
  background: #fff;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
  padding: 15px;
  margin-bottom: 20px;
}

.container-img-upload {
  display: flex;
  justify-content: space-between;
}

.wrapper-img {
  height: 150px;
  width: 150px;
  position: relative;
  border: 2px dashed #d9d9d9;
  border-radius: 5px;
  /* overflow: hidden; */
  z-index: 1;
}

.wrapper-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.wrapper-img .name-img {
  position: absolute;
  bottom: -35px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 14px;
  color: #606266;
}

.wrapper-img .set-icon {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #fff;
}

.file-upload {
  position: absolute;
  bottom: 0px;
  outline: none;
  color: transparent;
  width: 100%;
  height: 100%;
  box-sizing: border-box;
  cursor: pointer;
  transition: 0.5s;
  z-index: 2;
  display: block;
}

.file-upload::-webkit-file-upload-button {
  visibility: hidden;
}
</style>
