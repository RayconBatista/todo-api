<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <notifications position="top right" />
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
        alt="Your Company" />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
        Sign in to your account
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form @submit.stop.prevent="auth">
        <div class="space-y-6">
          <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
            <div class="mt-2">
              <input id="email" name="email" v-model="form.email" type="email" autocomplete="email"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between">
              <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
              <div class="text-sm">
                <router-link :to="{ name: 'forget.password' }"
                  class="font-semibold text-indigo-600 hover:text-indigo-500">
                  Forgot password?
                </router-link>
              </div>
            </div>
            <div class="mt-2">
              <input id="password" name="password" type="password" v-model="form.password" autocomplete="current-password"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div>
            <button type="submit"
              class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
              <span v-if="loading">Carregando...</span>
              <span v-else>Login</span>
            </button>
          </div>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Not a member?
        {{ " " }}
        <router-link :to="{ name: 'register' }" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">
          Sign Up
        </router-link>
      </p>
    </div>
  </div>
</template>
<script>
import router from "@/router";
import { ref, reactive, computed } from "vue";
import { useStore } from "vuex";
import { useNotification } from "@kyvg/vue3-notification";
import { useForm } from 'vee-validate';
import * as yup from 'yup';

export default {
  name: "Login",
  components: {
  },
  setup() {
    const store = useStore();
    const form = reactive({
      email: "",
      password: "",
    });
    const loading = ref(false);
    const { notify } = useNotification();
    const alert = computed(() => store.getters.alert)

    console.log({"ALERT": alert})

    const schema = yup.object({
      email: yup.string().email(),
    });

    const auth = async () => {
      loading.value = true;
      await schema.validateSync(form);
      store
        .dispatch("auth", {
          email: form.email,
          password: form.password,
        })
        .then(() => router.push({ name: "home" }))
        .catch((error) => {
          let msgError = "Falha na requisição";
          if (error?.status === 422) msgError = "Dados Inválidos";
          if (error?.status === 404) msgError = "Usuário Não Encontrado";

          notify({
            title: "Autenticação",
            text: msgError,
            type: "warn",
          });
        })
        .finally(() => (loading.value = false));
    };

    return {
      form,
      loading,
      auth,
    };
  },
};
</script>
