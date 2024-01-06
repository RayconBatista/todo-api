<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img
        class="mx-auto h-10 w-auto"
        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
        alt="Your Company"
      />
      <h2
        class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
      >
        Create new password
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <div class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900"
            >Email address</label
          >
          <div class="mt-2">
            <input
              id="email"
              name="email"
              v-model="email"
              type="email"
              autocomplete="email"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label
              for="password"
              class="block text-sm font-medium leading-6 text-gray-900"
              >Password</label
            >
          </div>
          <div class="mt-2">
            <input
              id="password"
              name="password"
              type="password"
              v-model="password"
              autocomplete="current-password"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <button
            @click.prevent="savePasswordReseted"
            type="submit"
            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            <span v-if="loading">Carregando...</span>
            <span v-else>Login</span>
          </button>
        </div>
      </div>

      <p class="mt-10 text-center text-sm text-gray-500">
        Not a member?
        {{ " " }}
        <router-link
          :to="{ name: 'register' }"
          class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
        >
          Save
        </router-link>
      </p>
    </div>
  </div>
</template>
<script>
import router from "@/router";
import { ref } from "vue";
import { useStore } from "vuex";
import { notify } from "@kyvg/vue3-notification";
import ResetPasswordService from "@/infra/services/password.reset.service";
export default {
  name: "ResetPassword",
  props: {
    token: {
      require: true,
    },
  },
  setup(props) {
    const email = ref("");
    const password = ref("");
    const loading = ref(false);
    const typePassword = ref("password");
    // const toggleShowPassword = () =>
    //   (typePassword.value = typePassword.value === "password" ? "text" : "password");
    const savePasswordReseted = () => {
      loading.value = true;
      ResetPasswordService.reset({
        email: email.value,
        password: password.value,
        token: props.token,
      })
        .then(() => {
          notify({
            title: "Sucesso",
            text: "Senha Atualizada com sucesso",
          });
          router.push({ name: "login" });
        })
        .catch(() =>
          notify({
            title: "Falha",
            text: "Falha ao recuperar o usuário",
            type: "warn",
          })
        )
        .finally(() => (loading.value = false));
    };
    return {
      savePasswordReseted,
      email,
      password,
      loading,
      typePassword,
      //   toggleShowPassword,
    };
  },
};
</script>
