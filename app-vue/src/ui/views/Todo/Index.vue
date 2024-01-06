<template>
    <div class="container">
        <div
            class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">
            <notifications position="top right" />
            <div class="flex justify-between mb-2">
                <ol class="flex text-gray-600 list-reset">
                    <li>
                        <router-link to="/home" class="dark:text-white">Home</router-link>
                    </li>
                    <li class="mx-2">/</li>
                    <li>
                        <router-link :to="{ name: 'todos.index' }" class="dark:text-white">Todos</router-link>
                    </li>
                </ol>
            </div>

            <input id="inline-password" type="text" v-model="form.label" v-on:keyup.enter="addTodo"
                class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 mb-4">

            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Index</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Usuário</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Tasks</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="todo in todos" :key="todo.id">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ todo.id }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ todo.label }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ todo?.user?.first_name }} {{ todo?.user?.last_name }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ todo.tasks.length }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <router-link :to="{ name: 'todos.single', params: { id: todo.id } }"
                                    class="px-1 py-1 mr-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    Visualizar
                                </router-link>
                                <button @click.stop.prevent="destroyTodo(todo.id)"
                                    class="px-1 py-1 font-bold text-white bg-red-500 rounded hover:bg-red-700">
                                    Remover
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
  
<script>
import { ref, onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import { useNotification } from "@kyvg/vue3-notification";
export default {
    name: "Todos",
    setup() {
        const store = useStore();
        const todos = computed(() => store.state.todos.todos);
        const tasks = computed(() => store.state.tasks);
        const { notify } = useNotification();
        const form = ref({ label: "" });

        onMounted(() => {
            store.dispatch('getTodos');
        });

        const getTodo = (id) => {
            store.dispatch('getTasks', id);
        }

        const addTodo = async () => {
            try {
                store.dispatch('storeTodo', { label: form.value.label }).then(() => {
                    notify({
                        title: "Deu certo",
                        text: "Todo registrado com sucesso",
                        type: "success",
                    });
                    store.dispatch('getTodos');
                    form.value.label = ''
                }).catch(() => {
                    notify({
                        title: "Deu ruim",
                        text: "Erro ao registrar todo",
                        type: "danger",
                    });
                });
            } catch (error) {
                console.error('Erro ao registrar o todo:', error);
            }
        };

        const destroyTodo = async (id) => {
            try {
                await store.dispatch('destroyTodo', id);
                notify({
                    title: "Deu certo",
                    text: "Todo excluido com sucesso",
                    type: "success",
                });
            } catch (error) {
                console.error('Erro ao excluir o todo:', error);
            }
        };

        return {
            todos,
            tasks,
            form,
            addTodo,
            getTodo,
            destroyTodo
        };
    }
};
</script>
  