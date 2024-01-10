<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <notifications position="top right" />
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
        alt="Your Company" />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
        Register your account
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent="signUp">
        <div>
          <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">Nome</label>
          <div class="mt-2">
            <input id="first_name" name="first_name" type="text" v-model="form.first_name" autocomplete="first_name"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>
        <div>
          <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Sobrenome</label>
          <div class="mt-2">
            <input id="last_name" name="last_name" type="text" v-model="form.last_name" autocomplete="last_name"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>
        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
          <div class="mt-2">
            <input id="email" name="email" type="email" v-model="form.email" autocomplete="email"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          </div>
          <div class="mt-2">
            <input v-model="form.password" id="password" name="password" type="password" autocomplete="current-password"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div>
          <button type="submit"
            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Cadastre-se
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Has an account?
        {{ " " }}
        <router-link :to="{ name: 'login' }" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">
          Sign In
        </router-link>
      </p>
    </div>
  </div>
</template>
<script>
import { computed, onMounted, reactive } from 'vue';
import { useStore } from "vuex";
import { useRoute } from 'vue-router';
import { useNotification } from "@kyvg/vue3-notification";
export default {
  name: "register",
  setup() {
    const store = useStore();
    const router = useRoute();
    const { notify } = useNotification();
    const inviteEmail = router.query.invite_email;

    const form = reactive({
      first_name: "Fulano",
      last_name: "Test",
      email: inviteEmail ?? "",
      password: "Ft123456789",
    });
    const signUp = async () => {
      await store.dispatch("storeUser", form);
 
      router.push({name: 'login'})
    }

    return {
      form,
      signUp
    }
  }
};
</script>
