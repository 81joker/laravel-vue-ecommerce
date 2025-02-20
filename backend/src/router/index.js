import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import Login from "../views/Login.vue";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import AppLayout from "@/components/AppLayout.vue";
import Dashboard from "@/views/Dashboard.vue";
import Products from "@/views/Products/Products.vue";
import Orders from "@/views/Orders/Orders.vue";
import NotFount from "@/views/NotFount.vue";
import store from "@/store";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: HomeView,
        },
        {
            path: "/app",
            name: "app",
            redirect: "/app/dashboard",
            component: AppLayout,
            meta: {
                requiresAuth: true,
            },
            children: [
                {
                    path: "dashboard",
                    name: "app.dashboard",
                    component: Dashboard,
                },
                {
                  path: 'products',
                  name: 'app.products',
                  component: Products
                },
                {
                  path: 'orders',
                  name: 'app.orders',
                  component: Orders
                },
                // {
                //   path: 'users',
                //   name: 'app.users',
                //   component: Users
                // },
            ],
        },
        {
            path: "/login",
            name: "login",
            component: Login,
            meta: {
                requiresGuest: true
              }
        },
        {
            path: "/request-password",
            name: "requestPassword",
            component: RequestPassword,
        },
        {
            path: "/reset-password:token",
            name: "resetPassword",
            component: ResetPassword,
        },
        {
            path: "/:pathMatch(.*)",
            name: "notfount",
            component: NotFount,
        },
    ],
});


// to represents the route object that is being navigated to.
// from represents the route object that is being navigated away from.
// next is a function that must be called to resolve the navigation.
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: "login" });
    } else if (to.meta.requiresGuest && store.state.user.token) {
        next({ name: "app.dashboard" });
    } else {
        next();
    }
});

export default router;
