<template>
  <div class="wrap-component">
    <!-- Thêm -->
    <el-button
      icon="el-icon-circle-plus-outline"
      class="btn-add"
      type="primary"
      @click="dialogFormAdd = true"
      >Thêm</el-button
    >

    <el-dialog title="Thêm Loại Mới" :visible.sync="dialogFormAdd">
      <el-form :model="form.add" :rules="rules" ref="formadd">
        <el-form-item
          label="Tên Loại"
          prop="name"
          :label-width="formLabelWidth"
        >
          <el-input v-model="form.add.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-row>
          <el-col :span="12">
            <el-form-item
              label="Tên NCC"
              prop="idDistributor"
              :label-width="formLabelWidth"
            >
              <el-select
                v-model="form.add.idDistributor"
                placeholder="Nhà Cung Cấp"
              >
                <el-option
                  v-for="item in data.distributors"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Loại SP Cha" :label-width="formLabelWidth">
              <el-select v-model="form.add.idParent" placeholder="Loại SP Cha">
                <el-option
                  v-for="item in data.categoriesParent"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormAdd = false">Hủy Bỏ</el-button>
        <el-button type="primary" @click="handleSubmit('formadd')"
          >Ghi</el-button
        >
      </span>
    </el-dialog>

    <!-- Sửa -->
    <el-dialog title="Chỉnh sửa NCC" :visible.sync="dialogFormEdit">
      <el-form :model="form.edit" :rules="rules" ref="formedit">
        <el-form-item
          label="Tên Loại"
          prop="name"
          :label-width="formLabelWidth"
        >
          <el-input v-model="form.edit.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-row>
          <el-col :span="12">
            <el-form-item
              label="Tên NCC"
              prop="idDistributor"
              :label-width="formLabelWidth"
            >
              <el-select
                v-model="form.edit.idDistributor"
                placeholder="Nhà Cung Cấp"
              >
                <el-option
                  v-for="item in data.distributors"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Loại SP Cha" :label-width="formLabelWidth">
              <el-select v-model="form.edit.idParent" placeholder="Loại SP Cha">
                <el-option
                  v-for="item in data.categoriesParent"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormEdit = false">Hủy Bỏ</el-button>
        <el-button type="primary" @click="editCategory">Ghi</el-button>
      </span>
    </el-dialog>

    <el-table :data="data.categories" slot="empty" empty-text="Bảng Rỗng">
      <el-table-column prop="id" label="ID"> </el-table-column>
      <el-table-column prop="name" label="Tên Loại"> </el-table-column>
      <el-table-column prop="idDistributor" label="NCC"> </el-table-column>
       <el-table-column prop="idParent" label="Loại SP Cha" align="center"> </el-table-column>
      <el-table-column label="Thao tác">
        <template slot-scope="scope">
          <el-button
            icon="el-icon-edit"
            size="mini"
            @click="handleEdit(scope.$index, scope.row)"
            >Sửa</el-button
          >
          <el-button
            icon="el-icon-delete"
            size="mini"
            type="danger"
            @click="handleDelete(scope.$index, scope.row)"
            >Xóa</el-button
          >
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      data: {
        distributors: [],
        categories: [],
        categoriesParent: [],
      },
      form: {
        add: {
          name: "",
          idDistributor: "",
          idParent: null,
        },
        edit: {
          id: null,
          name: "",
          idDistributor: "",
          idParent: null,
        },
      },
      rules: {
        name: [
          {
            required: true,
            message: "Vui lòng nhập tên loại sản phẩm",
            trigger: "blur",
          },
          {
            min: 2,
            max: 50,
            message: "Độ dài từ 3 -> 50",
            trigger: "blur",
          },
        ],
        idDistributor: [
          {
            type: "date",
            required: true,
            message: "Chưa chọn nhà cung cấp",
            trigger: "change",
          },
        ],
      },
      formLabelWidth: "120px",
      dialogFormEdit: false,
      dialogFormAdd: false,
    };
  },
  created() {
    this.getAllDistributors();
    this.getAllCategory();
  },

  methods: {
    getAllDistributors() {
      axios
        .get("distributor")
        .then((result) => {
          this.data.distributors = result.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllCategory() {
      axios
        .get("category")
        .then((result) => {
          this.data.categories = result.data.data;
          this.getListParent(this.data.categories);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getListParent(list) {
      this.data.categoriesParent.push({
        id: null,
        name: "--------",
      });
      list.forEach((element) => {
        if (!element.idParent) {
          this.data.categoriesParent.push({
            id: element.id,
            name: element.name,
          });
        }
      });
      console.log(this.data.categoriesParent);
    },
    handleSubmit(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          axios
            .post("category", this.form.add)
            .then((result) => {
              this.dialogFormAdd = false
              console.log(result);
              this.$swal({
                icon: "success",
                title: "Thêm Hãng thành công",
                showConfirmButton: false,
              });
              this.getAllCategory();
            })
            .catch((err) => {
              console.log(err);
              this.$swal({
                icon: "error",
                title: "Thêm Loại Sản Phẩm Lỗi",
                text: err,
                showConfirmButton: false,
              });
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    search(nameKey, myArray) {
      for (var i = 0; i < myArray.length; i++) {
        if (myArray[i].name === nameKey) {
          return myArray[i].id;
        }
      }
    },
    handleEdit(index, row) {
      this.dialogFormEdit = true;
      this.form.edit = row;
      console.log(index, row);
      this.form.edit.idDistributor = this.search(
        this.form.edit.idDistributor,
        this.data.distributors
      );
    },
    editCategory() {
      this.dialogFormEdit = false;
      this.$swal
        .fire({
          title: "Bạn muốn sửa?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Vâng tôi đồng ý",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .post("category", this.form.edit)
              .then((result) => {
                console.log(result);
                this.$swal({
                  icon: "success",
                  title: "Sửa Loại Sản Phẩm Thành Công",
                  showConfirmButton: false,
                });
                this.getAllCategory();
              })
              .catch((err) => {
                console.log(err);
                this.$swal({
                  icon: "error",
                  title: "Sửa Loại Sản Phẩm Lỗi",
                  text: err,
                  showConfirmButton: false,
                });
              });
          }
        });
    },
    handleDelete(index, row) {
      console.log(index, row);
      const swalWithBootstrapButtons = this.$swal.mixin({
        customClass: {
          confirmButton: "btn btn-success btn-margin",
          cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
      });

      swalWithBootstrapButtons
        .fire({
          title: "Bạn có chắc chứ?",
          text: "Bạn sẽ không phục hồi được sau khi xóa!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Vâng, xóa nó!",
          cancelButtonText: "Không!",
          reverseButtons: true,
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .delete(`category/${row.id}`)
              .then((res) => {
                
                console.log(res)
                if (!res.data.mess) {
                  swalWithBootstrapButtons.fire("Đã Xóa!", "", "success");
                  this.getAllCategory();
                } else {
                  swalWithBootstrapButtons.fire("Lỗi!", res.data.mess, "error");
                }
                
              })
              .catch((err) => {
                swalWithBootstrapButtons.fire("Lỗi~~~", `${err}`, "error");
              });
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === this.$swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire("Đã hủy", "", "error");
          }
        });
    },
  },
};
</script>

<style></style>
