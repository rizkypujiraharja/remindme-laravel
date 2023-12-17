import { createRouter, createWebHistory } from "vue-router";

import Reminders from "../pages/Reminders.vue";

const routes = [
    {
        path: "/reminders",
        name: "reminders",
        component: Reminders,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
