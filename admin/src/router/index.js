/** @format */

import { createRouter, createWebHistory } from "vue-router";
import Login from "@/views/login.vue";
import Register from "@/views/register.vue";
import Dashboard from "@/views/dashboard.vue";
import Student from "@/views/student.vue";
import Performance from "@/views/performance.vue";
import Beta from "@/views/beta.vue";
import Ui from "@/views/ui.vue";
import Classes from "@/views/classes.vue";
import Schedule from "@/views/schedule.vue";
import Grading from "@/views/grading.vue";
import Header from "@/components/header.vue";
import card from "@/views/card.vue";
import Sidebar from "@/components/appsidebar.vue";
import dash from "@/components/dash.vue";
import admin from "@/views/admin.vue";
import userlogin from "@/views/userlogin.vue";
import status from "@/views/status.vue";
import adminSi from "@/views/admin-si.vue";
import fetchStudent from "@/views/fetch-student.vue";
import FetchPrograms from "@/views/fetch-programs.vue";
import Manageblocks from "@/views/manageblocks.vue";
import Class from "@/views/class.vue";

const routes = [
  { path: "/", redirect: "/login" }, // Redirect "/" to Login
  { path: "/login", component: Login },
  { path: "/register", component: Register },
  { path: "/dashboard", component: Dashboard },
  { path: "/student", component: Student },
  {
    path: "/performance/:id",
    component: Performance,
    meta: { requiresAuth: true, role: "teacher" },
    children: [
      {
        path: "/dash",
        name: "Dash",
        component: dash,
      },
      {
        path: "/class",
        name: "Class",
        component: Class,
      },
    ],
  },
  {
    path: "/admin",
    component: admin,
    meta: { requiresAdmin: true },
    children: [
      {
        path: "", // 👈 this is the default route
        name: "dash",
        component: dash,
      },

      {
        path: "/status",
        name: "Status",
        component: status,
      },

      {
        path: "/admin-si",
        name: "Admin-Si",
        component: adminSi,
      },
      {
        path: "/fetch-student",
        name: "Fetch-Student",
        component: fetchStudent,
      },
      {
        path: "/fetch-programs",
        name: "Fetch-Programs",
        component: FetchPrograms,
      },
      {
        path: "/managedblocks",
        name: "Managed-Blocks",
        component: Manageblocks,
      },
    ],
  },
  { path: "/beta", component: Beta },
  { path: "/ui", component: Ui },
  { path: "/classes", component: Classes },
  { path: "/Schedule", component: Schedule },
  { path: "/grading", component: Grading },
  { path: "/card", component: card, name: "card" },
  { path: "/userlogin", component: userlogin },
  { path: "/status", component: status },
  { path: "/admin-si", component: adminSi },

  {
    path: "/header",
    component: Header,
  },
  {
    path: "/appsidebar",
    component: Sidebar,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
