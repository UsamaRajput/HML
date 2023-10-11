import { createRouter, createWebHistory } from 'vue-router'


const routes = [
  {
    path: "/",
    name: "Home",
    component: ()=> import("../components/home.vue"),
  }
];


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: routes
  })

  export default router
