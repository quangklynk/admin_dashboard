<template>
  <div>
    <input type="file" @change="previewFiles" multiple accept="image/jpeg" />
    <button @click="handleFileUpload">Upload</button>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      data: {
        idEmployee: this.$store.getters.id,
        image: "",
      },
    };
  },
  methods: {
    previewFiles(event) {
      this.data.image = event.target.files[0];
    },
    handleFileUpload() {
      console.log(this.data);
      let fd = new FormData();

      fd.append("image", this.data.image);
      fd.append("idEmployee", this.data.idEmployee);
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
            title: "Thêm Hãng thành công",
            showConfirmButton: false,
          });
        })
        .catch((err) => {
          console.log(err.message);
        });
    },
  },
};
</script>

<style scoped></style>
