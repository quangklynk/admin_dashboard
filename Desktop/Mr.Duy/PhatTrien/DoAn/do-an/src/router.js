import Vue from "vue";
import Router from "vue-router";

import  Menu  from "./components/Menu.vue";

import  Test  from "./components/Test/Index.vue";
import  Train  from "./components/Train/Index.vue";

Vue.use(Router);

const router = new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      component: Menu,
      children: [
        { path: "/test", component: Test },
        { path: "/train", component: Train },
      ],
    },
  ],
});

export default router;
