<template>
  <div class="container-slide">
    <el-button type="primary" @click="dialogVisibleadd = true">Thêm</el-button>
    <div class="block">
      <el-dialog
        title="Thêm Slide"
        :visible.sync="dialogVisibleadd"
        :before-close="handleClose"
        width="30%"
      >
        <div class="wrapper-img">
          <img
            v-if="!image_uploadadd"
            src="./../../../assets/imgs/More/empty-img.png"
          />
          <img v-else :src="image_uploadadd" alt="" />
          <input
            accept="image/jpeg"
            type="file"
            class="file-upload"
            ref="uploadadd"
            @change="showImgAdd"
          />
        </div>
        <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="subimitAdd">Thêm</el-button>
        </span>
      </el-dialog>

      <el-dialog title="Sửa Slide" :visible.sync="dialogVisible" width="30%">
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
        <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="submitEdit">Sửa</el-button>
        </span>
      </el-dialog>
      <el-card
        :body-style="{ width: 100, padding: 0 }"
        v-for="(item, index) in data.slides"
        :key="index"
      >
        <img
          :src="item.image"
          class="image custome"
          style="
            width: -webkit-fill-available;
            object-fit: cover;
            height: 200px;
          "
        />
        <div style="padding: 14px">
          <span>Người tạo: {{ item.employee.name }}</span>
          <div class="bottom clearfix">
            <time class="time"
              >Ngày tạo: {{ item.created_at | formatDate }}</time
            >
            <el-button-group>
              <el-button icon="el-icon-edit" @click="hadleOpenEdit(item.id)"
                >Sửa</el-button
              >
              <el-button
                type="danger"
                icon="el-icon-delete"
                @click="handleDelete(item.id)"
                >Xóa</el-button
              >
            </el-button-group>
          </div>
        </div>
      </el-card>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Slide",
  data() {
    return {
      dialogVisible: false,
      dialogVisibleadd: false,
      image_uploadadd: "",
      image_upload: "",
      data: {
        slides: [],
      },
      defaulPath: "http://localhost/image/slide/",
      formEdit: {
        idEmployee: this.$store.getters.id,
        image: "",
        id: null,
      },
      formAdd: {
        idEmployee: this.$store.getters.id,
        image: "",
      },
    };
  },
  methods: {
    showImgAdd(e) {
      this.image_uploadadd = URL.createObjectURL(e.target.files[0]);
      this.formAdd.image = e.target.files[0];
    },
    showImg(e) {
      this.image_upload = URL.createObjectURL(e.target.files[0]);
      this.formEdit.image = e.target.files[0];
    },
    getAllSlide() {
      axios
        .get(`slide`)
        .then((result) => {
          this.data.slides = result.data.data;
          console.log(this.data.slides);
          this.data.slides.forEach((element) => {
            element.image = this.defaulPath + element.image;
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    hadleOpenEdit(id) {
      this.formEdit.id = id;
      this.dialogVisible = true;
    },
    handleDelete(id) {
      this.$swal
        .fire({
          title: "Bạn có chắc chứ?",
          text: "Bạn sẽ không phục hồi được Slide!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Vâng, xóa nó!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .delete(`slide/${id}`)
              .then(() => {
                this.$swal.fire("Đã xóa!", "Silde đã xóa.", "success");
                this.getAllSlide()
              })
              .catch((err) => {
                console.log(err);
              });
          }
        });
    },
    submitEdit() {
      if (!this.formEdit.image || this.formEdit.image == "") {
        this.$notify({
          title: "Cảnh báo",
          message: "Bạn chưa nhập hình ảnh",
          type: "warning",
          offset: 100,
        });
        return;
      }
      let fd = new FormData();
      this.dialogVisible = false
      fd.append("image", this.formEdit.image);
      fd.append("idEmployee", this.formEdit.idEmployee);
      fd.append("id", this.formEdit.id);
      axios({
        method: "POST",
        url: "http://localhost/api/slide",
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
            title: "Sửa slide thành công",
            showConfirmButton: false,
          });
          this.getAllSlide()
        })
        .catch((err) => {
          console.log(err.message);
          this.$swal({
            icon: "error",
            title: "Sửa slide thất bại",
            text: err.message,
            showConfirmButton: false,
          });
        });
    },
    subimitAdd() {
      if (!this.formAdd.image || this.formAdd.image == "") {
        this.$notify({
          title: "Cảnh báo",
          message: "Bạn chưa nhập hình ảnh",
          type: "warning",
          offset: 100,
        });
        return;
      }

      let fd = new FormData();
      this.dialogVisibleadd = false
      fd.append("image", this.formAdd.image);
      fd.append("idEmployee", this.formAdd.idEmployee);
      axios({
        method: "POST",
        url: "http://localhost/api/slide",
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
            title: "Thêm slide thành công",
            showConfirmButton: false,
          });
          this.getAllSlide()
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
    handleClose() {
      this.$refs.uploadadd.value = null;
      this.dialogVisibleadd = false;
      this.image_uploadadd = "";
    },
  },
  async mounted() {
    this.getAllSlide();
  },
};
</script>

<style scoped>
.container-slide {
  text-align: left;
}

.block {
  text-align: left;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  justify-content: center;
  gap: 20px;
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
  margin: 0 auto;
}

.wrapper-img img {
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