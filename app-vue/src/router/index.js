import { createWebHistory, createRouter } from "vue-router";
import { authPages } from "./auth";
import { pages } from "./pages";
import { templates } from "./templates";
import store from "@/store";
import { TOKEN_NAME } from "@/infra/configs";

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
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

router.beforeEach(async (to, _, next) => {
  const loggedIn = store.state.users.loggedIn;
  document.title = to.meta.title;

  if (to.name !== "reset.password" && !loggedIn) {
    const token = localStorage.getItem(TOKEN_NAME);

    if (!token && to.name !== "login" && to.name !== "forget.password") {
      return router.push({ name: "login" });
    }

    try {
      await store.dispatch("getMe");
    } catch (error) {
      if (to.name !== "login") return router.push({ name: "login" });
    }
  }

  next();
});

export default router;
