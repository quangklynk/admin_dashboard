<template>
  <div class="wapper-form">
    <el-form
      :model="ruleForm"
      :rules="rules"
      ref="ruleForm"
      label-width="120px"
      class="ruleFormBlog"
    >
      <el-form-item label="Tiêu đề Blog" prop="titleBlog">
        <el-input v-model="ruleForm.titleBlog"></el-input>
      </el-form-item>
      <el-form-item label="Nội dung" prop="content">
        <el-input
          class="text-height"
          type="textarea"
          v-model="ruleForm.content"
        ></el-input>
      </el-form-item>
      <el-form-item label="Hình ảnh">
        <div class="wrapper-img">
          <img
            v-if="!image_upload"
            src="./../../../assets/imgs/More/empty-img.png"
          />
          <img v-else :src="image_upload" alt="" />
          <input
            accept="image/jpeg"
            type="file"
            class="file-upload"
            id="fileupload-slide"
            ref="upload"
            @change="showImg"
          />
        </div>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="submitForm('ruleForm')"
          >Tạo</el-button
        >
        <el-button @click="resetForm('ruleForm')">Làm Mới</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      image_upload: "",
      disabled: false,
      limit: 1,
      ruleForm: {
        content: "",
        titleBlog: "",
        image: "",
        idEmployee: this.$store.getters.id,
      },
      rules: {
        titleBlog: [
          {
            required: true,
            message: "Vui lòng nhập tiêu đề",
            trigger: "blur",
          },
          {
            min: 3,
            max: 100,
            message: "Độ dài nên từ 3->100 kí tự",
            trigger: "blur",
          },
        ],
        content: [
          {
            required: true,
            message: "Vui lòng nhập nội dung",
            trigger: "blur",
          },
          {
            min: 100,
            max: 3000,
            message: "Độ dài nên từ 100->3000 kí tự",
            trigger: "blur",
          },
        ],
      },
    };
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let fd = new FormData();

          console.log(this.ruleForm.image);

          fd.append("content", this.ruleForm.content);
          fd.append("titleBlog", this.ruleForm.titleBlog);
          fd.append("image", this.ruleForm.image);
          fd.append("idEmployee", this.ruleForm.idEmployee);

          axios({
            method: "POST",
            url: "http://localhost/api/blog",
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
                title: "Thêm Hãng thành công",
                showConfirmButton: false,
              });
            })
            .catch((err) => {
              console.log(err.message);
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    handleFileUpload() {
      this.image = this.$refs.upload.files[0];
      console.log(this.image);
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
      this.image_upload = "";
    },
    showImg(e) {
      this.image_upload = URL.createObjectURL(e.target.files[0]);
      this.ruleForm.image = e.target.files[0];
      console.log(this.ruleForm.image);
    },
  },
};
</script>

<style scoped>
.ruleFormBlog {
  text-align: left;
}

.wapper-form {
  background-color: #fff;
  padding: 25px 15px;
}
.wrappe-image {
  height: inherit;
}

.text-height textarea {
  min-height: 150px !important;
}

.wrapper-img {
  height: 200px;
  width: 200px;
  position: relative;
  border: 2px dashed #d9d9d9;
  border-radius: 5px;
  overflow: hidden;
  z-index: 1;
}

.wrapper-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.wrapper-img .default {
  position: absolute;
  top: -50%;
  left: -50%;
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

.popover {
  width: fit-content;
}

.file-upload::-webkit-file-upload-button {
  visibility: hidden;
}
</style>
