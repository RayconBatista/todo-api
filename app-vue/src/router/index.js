import { createWebHistory, createRouter, createWebHashHistory } from "vue-router";
import { authPages } from "./auth";
import { pages } from "./pages";
import { templates } from "./templates";
import store from "@/store";
import { TOKEN_NAME } from "@/infra/configs";
import { redirectIfAuthenticated } from "./middlewares";
const appName = import.meta.env.VITE_APP_NAME;

const routes = [
  {
    path: "/",
    component: templates.LayoutDefault,
    meta: {
      title: `Home - ${appName}`
    },
    children: [
      {
        path: "home",
        name: "home",
        component: pages.Dashboard,
      },
      {
        path: "users",
        name: "users",
        children: [
          {
            path: "",
            name: "users.index",
            component: pages.User,
          },
          {
            path: "invited",
            name: "users.invited",
            component: pages.Invite,
            meta: { title: `Convidados - ${appName}` },
          },
        ]
      },
      {
        path: "projects",
        name: "projects",
        children: [
          {
            path: "",
            name: "projects.index",
            component: pages.Project,
          },
          {
            path: ":id",
            name: "projects.single",
            component: pages.ProjectSingle,
          },
        ]
      },
      {
        path: "todos",
        name: "todos",
        children: [
          {
            path: "",
            name: "todos.index",
            component: pages.Todo,
          },
          {
            path: ":id",
            name: "todos.single",
            component: pages.TodoSingle,
          },
        ],

      },
      {
        path: "meu-perfil",
        name: "profile",
        component: pages.Profile,
        meta: { title: `Meu perfil - ${appName}` },
      },
    ],
  },
  {
    path: "/login",
    component: templates.LayoutAuth,
    meta: {
      title: "Login",
    },
    children: [{ path: "", name: "login", component: authPages.Login }],
  },
  {
    path: "/registro",
    meta: {
      title: "Cadastro",
    },
    component: templates.LayoutAuth,
    children: [{ path: "", name: "register", component: authPages.Register }],
  },
  {
    path: "/recuperar-senha",
    meta: {
      title: "Recuperar senha",
    },
    component: templates.LayoutAuth,
    children: [
      {
        name: "forget.password",
        path: "",
        component: authPages.ForgetPassword,
      },
    ],
  },
  {
    path: "/reset/:token",
    component: authPages.ResetPassword,
    props: true,
    children: [
      {
        name: "reset.password",
        path: "",
        component: authPages.ForgetPassword,
      },
    ]
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to, from, next) => {
  const loggedIn = await store.state.auth.loggedIn;
  document.title = await to.meta.title;

  // Verificar se a rota atual é a página de redefinição de senha
  const isResetPasswordRoute = to.name === 'forget.password';
  const token = localStorage.getItem(TOKEN_NAME);

  if (!loggedIn && !isResetPasswordRoute) {

    if (!token && to.fullPath !== "/login" && to.name !== "forget.password") {
      return next({ name: "login", replace: true });
    }

    try {
      await store.dispatch("getMe");
      await store.commit('CHANGE_LOADING', true);
      if(to.name === 'login') {
        return next({ name: "home" });
      }
      // return next({ name: "home", replace: true });
    } catch (error) {
      if (to.name !== "login") {
        // Redirecionar para a página de login, garantindo que a URL seja atualizada
        return next({ name: "login", replace: true });
      }
    }
  } else if (loggedIn && to.name === 'login') {
    await store.commit('CHANGE_LOADING', true);
    if(to.name === 'login') {
      return next({ name: "home" });
    }
  }

  next();
});






export default router;
