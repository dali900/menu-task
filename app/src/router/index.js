import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "currencies",
            component: () => import("../views/Currencies.vue"),
        },
    ],
});

export default router;
