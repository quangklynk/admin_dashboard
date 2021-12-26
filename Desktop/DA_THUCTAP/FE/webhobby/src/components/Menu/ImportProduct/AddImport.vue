<template>
  <div class="wapper-form">
    <el-form
      :model="dynamicValidateForm"
      ref="dynamicValidateForm"
      label-width="120px"
      class="demo-dynamic"
    >
      <el-form-item>
        <h4>Đơn Nhập Hàng</h4>
      </el-form-item>
      <el-row
        v-for="(domain, index) in dynamicValidateForm.list"
        :key="domain.key"
      >
        <el-col :span="7">
          <el-form-item
            :label="'Tên SP ' + index"
            :prop="'list.' + index + '.idProduct'"
            :rules="[
              {
                required: true,
                message: 'Chọn sản phẩm',
                trigger: 'change',
              },
            ]"
          >
            <el-select v-model="domain.idProduct" placeholder="Chọn">
              <el-option
                v-for="item in data.products"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              >
              </el-option>
            </el-select>
            <!-- <el-input v-model.number="domain.idProduct"></el-input> -->
          </el-form-item>
        </el-col>
        <el-col :span="7">
          <el-form-item
            :label="'SL ' + index"
            :prop="'list.' + index + '.unit'"
            :rules="[
              {
                required: true,
                message: 'Không nên bỏ trống',
                trigger: 'blur',
              },
              { type: 'number', message: 'Nhập số' },
            ]"
          >
            <el-input v-model.number="domain.unit"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="7">
          <el-form-item
            :label="'Giá ' + index"
            :prop="'list.' + index + '.price'"
            :rules="[
              {
                required: true,
                message: 'Không nên bỏ trống',
                trigger: 'blur',
              },
              { type: 'number', message: 'Nhập số' },
            ]"
          >
            <el-input v-model.number="domain.price"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="3">
          <el-button type="danger" @click.prevent="removeDomain(domain)"
            >Xóa</el-button
          >
        </el-col>
      </el-row>

      <el-form-item>
        <el-button type="primary" @click="submitForm('dynamicValidateForm')"
          >Nhập hàng</el-button
        >
        <el-button @click="addDomain">Thêm sản phẩm</el-button>
        <el-button @click="resetForm('dynamicValidateForm')">Reset</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      data: {
        products: [],
      },
      dynamicValidateForm: {
        list: [
          {
            key: 1,
            idProduct: null,
            unit: "",
            price: "",
          },
        ],
        idEmployee: this.$store.getters.id,
      },
    };
  },
  mounted() {
    this.getProductImport();
  },
  methods: {
    getProductImport() {
      axios
        .get(`entersticker/product`)
        .then((result) => {
          this.data.products = result.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          axios
            .post("entersticker", this.dynamicValidateForm)
            .then((result) => {
              console.log(result);
              this.$swal({
                icon: "success",
                title: "Nhập hàng thành công",
                showConfirmButton: false,
              });
              this.resetForm(formName)
            })
            .catch((err) => {
              console.log(err);
              this.$swal.fire({
                icon: "error",
                title: "Oops...",
                text: err,
              });
            });
          console.log(this.dynamicValidateForm);
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    },
    removeDomain(item) {
      var index = this.dynamicValidateForm.list.indexOf(item);
      if (index !== -1) {
        this.dynamicValidateForm.list.splice(index, 1);
      }
    },
    addDomain() {
      this.dynamicValidateForm.list.push({
        key: Date.now(),
        idProduct: "",
        unit: "",
        price: "",
      });
    },
  },
};
</script>

<style>
.ruleFormBlog {
  text-align: left;
}

.wapper-form {
  background-color: #fff;
  padding: 25px 15px;
}
</style>
