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
                    <li class="mx-2">/</li>
                    <li>
                        <router-link :to="{ name: 'todos.single', params: { id: todo?.id } }" class="dark:text-white">{{
                            todo?.label }}</router-link>
                    </li>
                </ol>
            </div>

            <input id="inline-password" type="text" v-model="form.label" v-on:keyup.enter="addTask(todo.id)"
                class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 mb-4">

            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Index</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Pronto</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Ações</th>
                        </tr>
                    </thead>
                    <tbody v-if="tasksByNotDone?.length > 0">
                        <tr v-if="todoCount === 0">
                            <td colspan="4">Nenhuma tarefa disponível.</td>
                        </tr>
                        <tr v-if="loading">
                            <td colspan="4" class="text-center p-2">Carregando...</td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="task in todo?.tasks?.data"
                            :key="task?.id">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ task?.id }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ task?.label }}
                            </th>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ task.is_completed == 1 ? "Finalizado" : "Não finalizado" }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button @click.stop.prevent="setDone(todo.id, task.id)"
                                    class="px-1 py-1 mr-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    Finalizar
                                </button>
                                <button @click.stop.prevent="destroyTask(todo.id, task.id)"
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
import { onMounted, computed, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute, useRouter } from 'vue-router';
import TaskService from '@/infra/services/tasks.service.js'
import { useNotification } from "@kyvg/vue3-notification";
export default {
    name: "Todo",
    setup() {
        const store = useStore();
        const route = useRoute();
        const router = useRouter();
        const loading = ref(false);
        const { notify } = useNotification();

        const todo = computed(() => store.getters.getTodoSelected);
        const todoCount = computed(() => store.getters.getTaskByTodoCount);
        const tasksByNotDone = computed(() => store.getters.tasksIsNotDone)
        const form = ref({ label: '' });

        onMounted(() => {
            store.dispatch('getTasks', route.params.id)
            store.dispatch('setTodo', route.params.id)
        });

        const addTask = async (todoId) => {
            try {
                await store.dispatch('storeTask', { id: todoId, label: form.value.label }).then(() => {
                    notify({
                        title: "Deu certo",
                        text: "Task registrado com sucesso",
                        type: "success",
                    });
                    store.dispatch('setTodo', route.params.id)
                    store.dispatch('getTasks', route.params.id)
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

        const setDone = async (todoId, taskId) => {
            try {
                await TaskService.setDone(todoId, taskId).then(() => {
                    notify({
                        title: "Deu certo",
                        text: "Task atualizado com sucesso",
                        type: "success",
                    });

                    store.dispatch('getTasks', route.params.id)
                }).catch((error) => {
                    console.log({ 'error': error?.data?.message })
                    notify({
                        title: "Erro ao deletar o todo",
                        text: error.data.message,
                        type: "danger",
                    });
                })
            } catch (error) {
                console.error('Erro ao deletar o todo:', error);
            } finally {
                loading.value = false;
            }
        }

        const destroyTask = async (todoId, taskId) => {
            try {
                await TaskService.destroyTask(todoId, taskId).then(() => {
                    notify({
                        title: "Deu certo",
                        text: "Task excluido com sucesso",
                        type: "success",
                    });
                    if (todo.value.tasks.length > 1) {
                        store.dispatch('setTodo', route.params.id)
                    } else {
                        router.push({ name: "todos.index" })
                    }
                }).catch((error) => {
                    console.log({ 'error': error?.data?.message })
                    notify({
                        title: "Erro ao deletar o todo",
                        text: error.data.message,
                        type: "danger",
                    });
                })
            } catch (error) {
                console.error('Erro ao deletar o todo:', error);
            } finally {
                loading.value = false;
            }
        };

        return {
            todo,
            todoCount,
            form,
            addTask,
            destroyTask,
            tasksByNotDone,
            setDone,
            loading
        };
    },
}
</script>
  