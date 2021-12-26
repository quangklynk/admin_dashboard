<template>
  <div class="block" v-loading="loading">
    <el-timeline>
      <el-timeline-item
        v-for="blog in blogs"
        :key="blog.id"
        :timestamp="blog.created_at | formatDate"
        placement="top"
      >
        <el-card>
          <div class="container-card">
            <div class="wrap-img"><img :src="blog.image" alt="" /></div>
            <div class="wrap-content">
              <h4>{{ blog.titleBlog }}</h4>
              <small>Tác giả: {{ blog.employee.name }}</small>
              <p>{{ blog.content }}</p>
              <div>
                <el-button-group>
                  <el-button
                    @click="getBlogById(blog)"
                    type="primary"
                    icon="el-icon-edit"
                  ></el-button>
                  <el-button
                    type="warning"
                    icon="el-icon-picture-outline"
                    @click="openEditImage(blog)"
                  ></el-button>
                  <el-button
                    type="danger"
                    icon="el-icon-delete"
                    @click="deleteBlog(blog.id)"
                  ></el-button>
                </el-button-group>
              </div>
            </div>
          </div>
        </el-card>
      </el-timeline-item>
    </el-timeline>
    <!-- Sửa thông tin -->
    <el-drawer
      title="Chỉnh sửa thông tin Blog"
      :visible.sync="drawer"
      direction="rtl"
      :before-close="handleClose"
    >
      <div class="wapper-form">
        <el-form
          :model="ruleForm"
          :rules="rules"
          ref="ruleForm"
          label-width="100px"
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
              :autosize="{ minRows: 4, maxRows: 8 }"
            ></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('ruleForm')"
              ><i class="el-icon-edit"></i>Sửa</el-button
            >
          </el-form-item>
        </el-form>
      </div>
    </el-drawer>

    <!-- Sửa hình -->
    <el-dialog
      title="Sửa ảnh Blog"
      :visible.sync="dialogVisibleEdit"
      :before-close="handleCloseDialog"
      width="30%"
    >
      <div class="form-edit-img">
        <img
          v-if="!image_uploadEdit"
          src="./../../../assets/imgs/More/empty-img.png"
        />
        <img v-else :src="image_uploadEdit" alt="" />
        <input
          accept="image/jpeg"
          type="file"
          class="file-upload"
          ref="uploadedit"
          @change="showImgEdit"
        />
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="submitEditImage">Sửa</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      blogs: [],
      // Edit image
      dialogVisibleEdit: false,
      editImage: {
        id: "",
        image: "",
        idEmployee: this.$store.getters.id,
      },
      image_uploadEdit: "",
      // edit info
      ruleForm: {
        id: null,
        content: "",
        titleBlog: "",
        idEmployee: this.$store.getters.id,
      },
      rules: {
        titleBlog: [
          {
            required: true,
            message: "Vui lòng nhập tiêu đề",
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
      drawer: false,

      defaut_path: "http://localhost/image/blog/",
      loading: true,
    };
  },
  mounted() {
    this.getAllBlog();
  },
  watch: {
    blogs: function () {
      if (typeof this.blogs !== "undefined" && this.blogs.length > 0) {
        this.loading = false;
      } else {
        this.loading = true;
      }
    },
  },
  methods: {
    getAllBlog() {
      axios
        .get("blog")
        .then((result) => {
          console.log(result);
          this.blogs = result.data.data;
          this.blogs.forEach((element) => {
            element.image = this.defaut_path + element.image;
          });
          console.log(this.blogs);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    // Sửa hình ảnh
    openEditImage(blog) {
      this.editImage.id = blog.id;
      this.image_uploadEdit = blog.image;
      this.dialogVisibleEdit = true;
    },
    submitEditImage() {
      if (!this.editImage.image || this.editImage.image == "") {
        this.$notify({
          title: "Cảnh báo",
          message: "Bạn chưa sửa hình ảnh",
          type: "warning",
          offset: 100,
        });
        return;
      }
      this.dialogVisibleEdit = false;
      let fd = new FormData();

      fd.append("image", this.editImage.image);
      fd.append("id", this.editImage.id);
      axios({
        method: "POST",
        url: "http://localhost/api/blog/update/image",
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
          this.getAllBlog();
        })
        .catch((err) => {
          console.log(err.message);
          this.$swal({
            icon: "error",
            title: err.message,
            showConfirmButton: false,
          });
        });
    },
    handleCloseDialog() {
      this.$refs.uploadedit.value = null;
      this.dialogVisibleEdit = false;
      this.image_uploadEdit = "";
    },
    showImgEdit(e) {
      this.image_uploadEdit = URL.createObjectURL(e.target.files[0]);
      this.editImage.image = e.target.files[0];
    },
    // Sửa thông tin Blog
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          axios
            .post("blog/update/info", this.ruleForm)
            .then((result) => {
              console.log(result);
              this.$message({
                message: "Đã chỉnh sửa thành công.",
                type: "success",
              });
              this.drawer = false;
            })
            .catch((err) => {
              this.$message.error(`Oops, ${err}.`);
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    handleRemove() {
      this.$refs.upload.clearFiles();
    },
    getBlogById(blog) {
      this.ruleForm.id = blog.id;
      this.ruleForm.titleBlog = blog.titleBlog;
      this.ruleForm.content = blog.content;
      this.ruleForm.image = blog.image;
      this.drawer = true;
    },
    deleteBlog(id) {
      this.$swal
        .fire({
          title: "Bạn có chắc chứ?",
          text: "Bạn sẽ không phục hồi được trang Blog!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Vâng, xóa nó!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .delete(`blog/${id}`)
              .then(() => {
                this.$swal.fire(
                  "Deleted!",
                  "Your file has been deleted.",
                  "success"
                );
              })
              .catch((err) => {
                console.log(err);
              });
          }
        });
    },
    handleClose(done) {
      this.$confirm(
        "Popup này sẽ đóng bạn có muốn hủy quá trình sửa dữ liệu?",
        "Warning",
        {
          confirmButtonText: "OK",
          cancelButtonText: "Không",
          type: "warning",
        }
      )
        .then(() => {
          done();
          this.$message({
            type: "success",
            message: "Đã hủy chỉnh sửa",
          });
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "Tiếp tục",
          });
        });
    },
  },
};
</script>

<style scoped>
.block {
  text-align: left;
}

.container-card {
  display: flex;
}

.container-card .wrap-img {
  flex-basis: 20%;
}

.container-card .wrap-img img {
  width: 100%;
}

.container-card .wrap-content {
  flex-basis: 80%;
  width: 100%;
  padding: 10px;
}

/* Form edit */

.form-edit-img {
  height: 200px;
  width: 200px;
  position: relative;
  border: 2px dashed #d9d9d9;
  border-radius: 5px;
  overflow: hidden;
  z-index: 1;
  margin: 0 auto;
}

.form-edit-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
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
