<template>
  <div>
    <el-table border :data="data.products" height="450" style="width: 100%">
      <el-table-column
        fixed
        prop="id"
        label="Mã SP"
        width="90"
        align="center"
        column-key="id"
        sortable
      >
      </el-table-column>
      <el-table-column fixed prop="name" label="Tên SP" width="120">
      </el-table-column>
      <el-table-column
        prop="price"
        label="Giá"
        width="120"
        column-key="price"
        sortable
      >
        <template slot-scope="scope">
          {{ formatPrice(scope.row.price) }}
        </template>
      </el-table-column>
      <el-table-column
        prop="unit"
        label="Số Lượng"
        width="120"
        align="center"
        column-key="unit"
        sortable
      >
      </el-table-column>
      <el-table-column prop="description" label="Mô tả" width="120" align="center">
        <template slot-scope="scope">
          <el-popover
            placement="bottom"
            title="Mô tả"
            width="500"
            trigger="click"
            :content="scope.row.description"
          >
            <el-button slot="reference">Mở xem</el-button>
          </el-popover>
        </template>
      </el-table-column>
      <el-table-column
        prop="discount"
        label="Giảm Giá"
        width="120"
        align="center"
        column-key="discount"
        sortable
      >
        <template slot-scope="scope"> {{ scope.row.discount }}% </template>
      </el-table-column>
      <el-table-column prop="flag" label="Trạng thái" width="100" align="center">
        <template slot-scope="scope"> {{ scope.row.flag ? "Đang bán" : "Đã Khóa" }} </template>
      </el-table-column>
      <el-table-column prop="category" label="Loại" width="120">
        <template slot-scope="scope">
          {{ scope.row.category.id + " - " + scope.row.category.name }}
        </template>
      </el-table-column>
      <el-table-column prop="avatar" label="Hình" width="100" align="center">
        <template slot-scope="scope">
          <el-popover placement="bottom" width="330" trigger="click">
            <img class="img-employee" :src="scope.row.avatar" alt="" />
            <el-button class="fix-heigh" type="primary" slot="reference"
              >Xem ảnh</el-button
            >
          </el-popover>
        </template>
      </el-table-column>
      <el-table-column
        fixed="right"
        label="Thao tác"
        width="100"
        align="center"
      >
        <template slot-scope="scope">
          <el-button @click="handleClick(scope.row)" type="text" size="small">
            Chi tiết
          </el-button>
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
        products: [],
      },
      defaulPath: "http://localhost/image/product/",
    };
  },
  mounted() {
    this.getAllProduct();
  },
  methods: {
    handleClick(row) {
      console.log(row.id);
      this.$router.push({ path: `/menu/product/${row.id}` });
    },
    getAllProduct() {
      axios
        .get("/product")
        .then((result) => {
          this.data.products = result.data.data;
          console.log(result);
          this.data.products.forEach((element) => {
            element.avatar = this.defaulPath + element.avatar;
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " ₫";
    },
  },
};
</script>

<style></style>
