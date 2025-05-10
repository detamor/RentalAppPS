import { createRouter, createWebHistory } from "vue-router";
import GameList from "../components/GameList.vue";
import GameCreate from "../components/GameCreate.vue";
import GameDetails from "../components/GameDetails.vue";
import GameEdit from "../components/GameEdit.vue";
import CustomerList from "../components/CustomerList.vue";
import CustomerCreate from "../components/CustomerCreate.vue";
import CustomerDetails from "../components/CustomerDetails.vue";
import CustomerEdit from "../components/CustomerEdit.vue";
import UserList from "../components/UserList.vue";
import UserCreate from "../components/UserCreate.vue";
import UserDetails from "../components/UserDetails.vue";
import UserEdit from "../components/UserEdit.vue";
import Login from "../components/Login.vue";
import OrderList from "../components/OrderList.vue";
import OrderDetails from "../components/OrderDetails.vue";
import OrderCreate from "../components/OrderCreate.vue";
import OrderEdit from "../components/OrderEdit.vue";
import PaymentList from "../components/PaymentList.vue";
import PaymentDetails from "../components/PaymentDetails.vue";
import PaymentCreate from "../components/PaymentCreate.vue";
import PaymentEdit from "../components/PaymentEdit.vue";
import Register from "../components/Register.vue";
import { useAuthStore } from "../stores/auth";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      redirect: "/login",
    },
    {
      path: "/register",
      name: "register",
      component: Register,
    },
    {
      path: "/game",
      name: "home",
      component: GameList,
    },
    {
      path: "/game",
      name: "gamelist",
      component: GameList,
    },
    // Login route
    {
      path: "/",
      name: "login",
      component: Login,
    },
    {
      path: "/create",
      name: "gamecreate",
      component: GameCreate,
    },
    {
      path: "/game/:id",
      name: "gamedetail",
      component: GameDetails,
    },
    {
      path: "/game/:id/edit",
      name: "gameedit",
      component: GameEdit,
    },
    {
      path: "/customers",
      name: "customerlist",
      component: CustomerList,
    },
    {
      path: "/customers/create",
      name: "CustomerCreate",
      component: CustomerCreate,
    },
    {
      path: "/customers/:id",
      name: "customerdetail",
      component: CustomerDetails,
    },
    {
      path: "/customers/:id/edit",
      name: "customeredit",
      component: CustomerEdit,
    },
    {
      path: "/users",
      name: "userlist",
      component: UserList,
    },
    {
      path: "/users/create",
      name: "usercreate",
      component: UserCreate,
    },
    {
      path: "/users/:id",
      name: "userdetail",
      component: UserDetails,
    },
    {
      path: "/users/:id/edit",
      name: "useredit",
      component: UserEdit,
    },
    // Order list route
    {
      path: "/orders",
      name: "orderlist",
      component: OrderList,
    },
    // Create order route
    {
      path: "/orders/create",
      name: "ordercreate",
      component: OrderCreate,
    },
    // Order details route
    {
      path: "/orders/:id",
      name: "orderdetail",
      component: OrderDetails,
    },
    // Edit order route
    {
      path: "/orders/:id/edit",
      name: "orderedit",
      component: OrderEdit,
    },
    {
      path: "/payments",
      name: "paymentlist",
      component: PaymentList,
    },
    {
      path: "/payments/create",
      name: "paymentcreate",
      component: PaymentCreate,
    },
    {
      path: "/payments/:id",
      name: "paymentdetail",
      component: PaymentDetails,
    },
    {
      path: "/payments/:id/edit",
      name: "paymentedit",
      component: PaymentEdit,
    },
  ],
});
// Add global navigation guards to the router
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  if (to.name !== "register" && to.name !== "login" && !authStore.isLoggedIn) {
    next({ name: "login" });
  } else {
    next();
  }
});

export default router;