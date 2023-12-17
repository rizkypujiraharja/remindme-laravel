import { createRouter, createWebHistory } from "vue-router";

import Reminders from "../pages/Reminders.vue";
import Login from "../pages/Login.vue";

const routes = [
    {
        path: "/reminders",
        name: "reminders",
        component: Reminders,
    },
    {
        path: "/login",
        name: "login",
        component: Login,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
