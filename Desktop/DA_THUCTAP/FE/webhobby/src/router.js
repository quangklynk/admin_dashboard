import Vue from 'vue'
import Router from 'vue-router'

import Login from './components/_auth/Login.vue';
import MenuLogin from './components/_auth/Index.vue';
import Reset from './components/_auth/Reset.vue';
import Forgot from './components/_auth/Forgot.vue';

import Menu from './components/Menu/index.vue';
import Dashboard from "./components/Menu/Dashboard.vue";
import Blog from "./components/Menu/Blog/Index.vue";
import AddBlog from "./components/Menu/Blog/AddBlog.vue";
import Slide from "./components/Menu/Slide/Index.vue";

import Order from "./components/Menu/Order/Index.vue";

import ImportProduct from "./components/Menu/ImportProduct/Index.vue";
import AImportProduct from "./components/Menu/ImportProduct/AddImport.vue";

import Manufacturer from "./components/Menu/More/Manufacturer.vue";
import Status from "./components/Menu/More/Status.vue";
import Distributor from "./components/Menu/More/Distributor.vue";
import Category from "./components/Menu/More/Category.vue";
import Employee from "./components/Menu/Employee/Index.vue";
import AddEmployee from "./components/Menu/Employee/Add_Employee.vue";
import EditEmployee from "./components/Menu/Employee/Edit_Employee.vue";
import Error from "./components/Error/404.vue";
import Role from "./components/Menu/More/Role.vue";

// ---Customer
import Customer from "./components/Menu/Customer/Index.vue";

// ---Product
import Product from "./components/Menu/Product/Index.vue";
import AddProduct from "./components/Menu/Product/AddProduct.vue";
import ElementProduct from "./components/Menu/Product/Element.vue";

//---Info User Login
import MenuUser from "./components/InfoUser/Info.vue"
import User from "./components/InfoUser/User.vue"
import ChangePass from "./components/InfoUser/ChangePass.vue"

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/', component: MenuLogin, children: [
                { path: '/', component: Login, },
                { path: '/reset', component: Reset, },
                { path: '/forgot', component: Forgot, },
            ]
        },

        {
            path: '/user', component: MenuUser, children: [
                { path: '/user/', component: User, },
                { path: '/user/changepass', component: ChangePass, },
            ]
        },
        {
            path: '/menu', component: Menu, meta: { text: 'Menu' }, children: [
                { path: '/menu/', component: Dashboard, meta: { text: '' }, name: 'index' },

                { path: '/menu/blog', component: Blog, meta: { text: 'Blog' }, name: 'blog' },
                { path: '/menu/add-blog', component: AddBlog, meta: { text: 'Thêm Blog' }, name: 'add-blog' },

                { path: '/menu/slide', component: Slide, meta: { text: 'Slide' }, name: 'slide' },

                { path: '/menu/order', component: Order, meta: { text: 'Hóa đơn' }, name: 'order' },

                { path: '/menu/product', component: Product, meta: { text: 'Sản phẩm' }, name: 'product' },
                { path: '/menu/add-product', component: AddProduct, meta: { text: 'Thêm Sản phẩm' }, name: 'addproduct' },
                { path: '/menu/product/:id', component: ElementProduct, meta: { text: 'Chi Tiết Sản phẩm' }, name: 'element' },

                { path: '/menu/import-product', component: ImportProduct, meta: { text: 'Hóa Đơn Nhập Hàng' }, name: 'import-product' },
                { path: '/menu/aimport-product', component: AImportProduct, meta: { text: 'Nhập hàng' }, name: 'aimport-product' },

                { path: '/menu/manufacturer', component: Manufacturer, meta: { text: 'Hãng' }, name: 'manufacturer' },

                { path: '/menu/status', component: Status, meta: { text: 'Trạng thái' }, name: 'status' },

                { path: '/menu/distributor', component: Distributor, meta: { text: 'Nhà cung cấp' }, name: 'distributor' },

                { path: '/menu/category', component: Category, meta: { text: 'Loại mặt hàng' }, name: 'category' },

                { path: '/menu/employee', component: Employee, meta: { text: 'Nhân viên' }, name: 'employee' },
                { path: '/menu/employee/:id', component: EditEmployee, meta: { text: 'Sửa Nhân viên' }, name: 'editemployee' },
                { path: '/menu/add_emp', component: AddEmployee, meta: { text: 'Add_Employee' }, name: 'add-employee' },

                { path: '/menu/role', component: Role, meta: { text: 'Quyền hạn' }, name: 'role' },

                { path: '/menu/customer', component: Customer, meta: { text: 'Khách Hàng' }, name: 'customer' },
            ]
        },
        { path: '/404', name: 'errorpage', component: Error },//token, user
        { path: '*', redirect: '/404' }
    ]
})
// router.beforeEach((to, from, next) => {
//     const loggedIn = localStorage.getItem('token');
//     if (to.path == '/forgot' || to.path == '/reset') {
//         next();
//     } else if (to.path != '/' && !loggedIn) {
//         next('/');
//     }
//     next();
// });


export default router