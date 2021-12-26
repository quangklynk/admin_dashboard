<template>
  <div>
    <el-row :gutter="20">
      <el-col :span="12" class="contain-wrap">
        <div class="main-img">
          <img :src="main_img" alt="" />
        </div>
        <div v-if="data.product.list_image.length != 0" class="child-list-img">
          <img :src="data.product.avatar" @mouseover="getpath" alt="" />
          <img
            @mouseover="getpath"
            v-for="item in data.product.list_image"
            :key="item.id"
            :src="item.image"
            alt=""
          />
        </div>
      </el-col>
      <el-col :span="12" class="contain-wrap">
        <div class="contain-info">
          <el-row :gutter="20" class="head-info">
            <el-col :span="12">
              <el-button-group>
                <el-button
                  @click="enableForm"
                  type="primary"
                  icon="fas fa-wrench"
                ></el-button>
                <el-button
                  @click="drawer = true"
                  type="warning"
                  icon="el-icon-picture"
                ></el-button>
                <el-button
                  v-if="data.product.flag == 1"
                  @click="handleDelete"
                  type="danger"
                  icon="el-icon-delete"
                ></el-button>
                <el-button
                  v-else
                  @click="handleBack"
                  type="info"
                  icon="el-icon-refresh-left"
                ></el-button>
              </el-button-group>
            </el-col>
            <el-col :span="4">
              <label>MASP {{ data.product.id }}</label>
            </el-col>
            <el-col :span="8">
              <label>view: {{ data.product.view }}</label>
            </el-col>
          </el-row>
          <el-form
            ref="form"
            :model="form"
            label-width="120px"
            :disabled="isDisabled"
            :rules="rules"
          >
            <el-form-item label="Tên" prop="name">
              <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="Giá" prop="price">
              <el-input v-model.number="form.price">
                <template slot="prepend">đ</template>
              </el-input>
            </el-form-item>
            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item label="Số Lượng" prop="unit">
                  <el-input v-model.number="form.unit">
                    <template slot="append">đv</template>
                  </el-input>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Khuyến Mãi" prop="discount">
                  <el-input v-model.number="form.discount">
                    <template slot="append">%</template>
                  </el-input>
                </el-form-item>
              </el-col>
            </el-row>

            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item label="Loại" prop="idCategory">
                  <el-select v-model="form.idCategory" placeholder="Chọn">
                    <el-option
                      v-for="item in data.category"
                      :key="item.id"
                      :label="item.name"
                      :value="item.id"
                    >
                      <span style="float: left">{{ item.name }}</span>
                      <span
                        style="float: right; color: #8492a6; font-size: 13px"
                        >NCC: {{ item.idDistributor }}</span
                      >
                    </el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Ưu tiên">
                  <el-radio-group v-model="form.remark">
                    <el-radio label="1">Có</el-radio>
                    <el-radio label="0">Không</el-radio>
                  </el-radio-group>
                </el-form-item>
              </el-col>
            </el-row>

            <el-form-item label="Mô tả" prop="description">
              <el-input type="textarea" v-model="form.description"></el-input>
            </el-form-item>

            <el-form-item>
              <el-button
                @click="handleEdit('form')"
                type="primary"
                icon="el-icon-edit"
                >Cập nhật
              </el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-col>
    </el-row>
    <el-drawer
      title="Chỉnh sửa hình ảnh"
      :visible.sync="drawer"
      direction="rtl"
      :before-close="handleClose"
    >
      <el-form :model="formImage">
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
        <el-form-item>
          <el-button type="primary" @click="handleEditImg" :loading="loading">
            {{ loading ? "Sửa ảnh ..." : "Sửa ảnh" }}
          </el-button>
        </el-form-item>
      </el-form>
    </el-drawer>
  </div>
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
      loading: false,
      data: {
        product: {
          list_image: [],
        },
        category: [],
      },

      form: {
        id: "",
        name: "",
        price: "",
        discount: "",
        unit: "",
        description: "",
        remark: "",
        idCategory: "",
      },

      formImage: {
        idProduct: "",
        idImg1: "",
        idImg2: "",
        idImg3: "",
        idImg4: "",
      },

      list_image_upload: {
        imgAvatar: "",
        img1: "",
        img2: "",
        img3: "",
        img4: "",
      },

      isDisabled: true,
      defaulPath: "http://localhost/image/product/",

      main_img:
        "https://specials-images.forbesimg.com/imageserve/609a78f59ba171be93705854/960x0.jpg?fit=scale",

      drawer: false,

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
  methods: {
    getCategory() {
      axios
        .get(`category`)
        .then((result) => {
          this.data.category = result.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getProductByID() {
      axios
        .get(`product/${this.$route.params.id}`)
        .then((result) => {
          this.data.product = result.data.data;
          this.data.product.avatar = this.defaulPath + this.data.product.avatar;
          this.main_img = this.data.product.avatar;
          this.data.product.list_image.forEach((element) => {
            element.image = this.defaulPath + element.image;
          });
          this.form = this.data.product;
          this.form.remark = this.form.remark.toString();
          this.formImage.idProduct = this.data.product.id;
          console.log(result);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getpath(e) {
      this.main_img = e.target.currentSrc;
    },
    handleEdit(formName) {
      console.log(this.form);
      this.$refs[formName].validate((valid) => {
        if (valid) {
          axios
            .patch(`product/updateinfo/${this.form.id}`, this.form)
            .then((result) => {
              console.log(result);
              this.$swal({
                icon: "success",
                title: "Sửa sản phẩm thành công",
                showConfirmButton: false,
              });
            })
            .catch((err) => {
              this.$swal({
                icon: "error",
                title: err,
                showConfirmButton: false,
              });
            });
        } else {
          console.log("error submit!!");
          this.$message({
            message: "Bạn chưa nhập đủ",
            type: "warning",
          });
          return false;
        }
      });
    },
    enableForm() {
      this.isDisabled = !this.isDisabled;
    },
    handleClose(done) {
      this.$confirm("Bạn có muốn đóng?")
        .then(() => {
          done();
        })
        .catch(() => {});
    },
    handleDelete() {
      this.$swal
        .fire({
          title: "Bạn có chắc chứ?",
          text: "Sản phẩm sẽ bị khóa",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Vâng, xóa nó!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .delete(`product/${this.form.id}`)
              .then(() => {
                this.data.product.flag = 0;
                this.$swal.fire(
                  "Đã khóa!",
                  "Sản phẩm sẽ không được bày bán.",
                  "success"
                );
              })
              .catch((err) => {
                console.log(err);
              });
          }
        });
    },
    handleBack() {
      this.$swal
        .fire({
          title: "Bạn sẽ phục hồi sản phẩm?",
          text: "Sản phẩm sẽ được bày bán lại!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Phục Hồi!",
          cancelButtonText: "Hủy!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .post(`product/${this.form.id}`)
              .then(() => {
                this.data.product.flag = 1;
                this.$swal.fire("Đã phục hồi!", "", "success");
              })
              .catch((err) => {
                console.log(err);
              });
          }
        });
    },
    handleEditImg() {
      console.log(this.formImage.imgAvatar);
      if (
        !this.list_image_upload.imgAvatar &&
        !this.list_image_upload.img1 &&
        !this.list_image_upload.img2 &&
        !this.list_image_upload.img3 &&
        !this.list_image_upload.img4
      ) {
        this.$message({
          message: "Chưa sự thay đổi(๑•̀ㅂ•́)و",
          type: "warning",
        });
        return;
      }
      this.loading = true;
      let fd = new FormData();
      fd.append("idPro", this.formImage.idProduct);
      if (this.formImage.imgAvatar) {
        fd.append("imgAvatar", this.formImage.imgAvatar);
      }
      if (this.formImage.img1) {
        fd.append("img1", this.formImage.img1);
        if (this.data.product.list_image[0]) {
          fd.append("idImg1", this.data.product.list_image[0].id);
        }
      }
      if (this.formImage.img2) {
        fd.append("img2", this.formImage.img2);
        if (this.data.product.list_image[1]) {
          fd.append("idImg2", this.data.product.list_image[1].id);
        }
      }
      if (this.formImage.img3) {
        fd.append("img3", this.formImage.img3);
        if (this.data.product.list_image[2]) {
          fd.append("idImg3", this.data.product.list_image[2].id);
        }
      }
      if (this.formImage.img4) {
        fd.append("img4", this.formImage.img4);
        if (this.data.product.list_image[3]) {
          fd.append("idImg4", this.data.product.list_image[3].id);
        }
      }
      axios({
        method: "POST",
        url: "http://localhost/api/product/updateimage/v1",
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
            title: "Sửa ảnh thành công",
            showConfirmButton: false,
          });
          this.loading = false;
          this.getProductByID();
          this.drawer = false;
        })
        .catch((err) => {
          console.log(err.message);
          this.$swal({
            icon: "success",
            title: "Sửa ảnh lỗi",
            text: err.message,
            showConfirmButton: false,
          });
        });
    },
    showImgA(e) {
      console.log(e);
      this.list_image_upload.imgAvatar = URL.createObjectURL(e.target.files[0]);
      this.formImage.imgAvatar = e.target.files[0];
    },
    showImg1(e) {
      console.log(e);
      this.list_image_upload.img1 = URL.createObjectURL(e.target.files[0]);
      this.formImage.img1 = e.target.files[0];
    },
    showImg2(e) {
      console.log(e);
      this.list_image_upload.img2 = URL.createObjectURL(e.target.files[0]);
      this.formImage.img2 = e.target.files[0];
    },
    showImg3(e) {
      console.log(e);
      this.list_image_upload.img3 = URL.createObjectURL(e.target.files[0]);
      this.formImage.img3 = e.target.files[0];
    },
    showImg4(e) {
      console.log(e);
      this.list_image_upload.img4 = URL.createObjectURL(e.target.files[0]);
      this.formImage.img4 = e.target.files[0];
    },
  },
  mounted() {
    this.getProductByID();
    this.getCategory();
  },
};
</script>

<style scoped>
.main-img {
  padding: 20px;
}

.main-img img {
  width: -webkit-fill-available;
  object-fit: cover;
  height: 318px;
}
.contain-wrap {
  background: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
  border-radius: 4px;
  height: 460px;
}
.child-list-img {
  width: 100%;
  display: flex;
  justify-content: center;
}

.child-list-img img {
  margin: 5px;
  width: 82px;
  height: 82px;
  object-fit: cover;
}

.child-list-img img:hover,
.child-list-img img:focus,
.child-list-img img:active {
  border: 2px solid #636f83;
}

.contain-info {
  text-align: left;
  padding: 10px;
}

.head-info {
  margin-bottom: 5px;
  text-align: left;
}

.container-img-upload {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.wrapper-img {
  height: 150px;
  width: 150px;
  position: relative;
  border: 2px dashed #d9d9d9;
  border-radius: 5px;
  /* overflow: hidden; */
  z-index: 1;
  margin-bottom: 15px;
}

.wrapper-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.wrapper-img .name-img {
  position: absolute;
  top: 50%;
  left: -95px;
  transform: translateY(-50%);
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

.el-drawer__header {
  text-align: left;
  font-weight: 600;
}
</style>
