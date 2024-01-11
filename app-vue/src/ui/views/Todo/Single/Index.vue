<template>
    <div class="container">
        <Header title="Todos" routeName="todos.index" routeSingleName="todos.single" :data="todo" />
        <div
            class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">

            <input id="inline-password" type="text" v-model="form.label" v-on:keyup.enter="addTask(todo.id)"
                class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 mb-4">

            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Index</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Status</th>
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
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            v-for="(task, index) in todo?.tasks?.data" :key="task?.id">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ task?.id }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ task?.label }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <span
                                    class="text-sm mb-2 mr-3 w-[100px] leading-6 inline-flex justify-center font-bold uppercase px-3 dark:text-white rounded-full"
                                    :style="`background-color: ${task?.status?.color}`">
                                    {{ task?.status?.label }}
                                </span>
                            </th>
                            <td class="px-6 py-4 flex justi-between">
                                <Modal ref="modalStatusRef" title="Alterar Status"
                                    :acceptFunction="() => changeStatus(index)" @close-modal="handleCloseModal"
                                    class="px-1 py-1 mr-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    <select v-model="form.status_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>Selecionar Status</option>
                                        <option v-for="status in listStatus" :key="status?.id" :value="status.id">
                                            {{ status.label }}
                                        </option>
                                    </select>
                                </Modal>
                                <!-- <button @click.stop.prevent="setDone(todo.id, task.id)"
                                    class="px-1 py-1 mr-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    Finalizar
                                </button> -->
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
import Header from '@/ui/components/Header.vue';
import Modal from '@/ui/components/Modal.vue';
import { onMounted, computed, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute, useRouter } from 'vue-router';
import TaskService from '@/infra/services/tasks.service.js'
import { useNotification } from "@kyvg/vue3-notification";
import { getTagColorClass } from '@/utils/tagColor';

export default {
    name: "Todo",
    components: {
        Header,
        Modal,
    },
    emits: ['close-modal'],
    setup() {
        const store = useStore();
        const route = useRoute();
        const router = useRouter();
        const loading = ref(false);
        const { notify } = useNotification();
        const modalStatusRef = ref(null);
        const todo = computed(() => store.getters.getTodoSelected);
        const todoCount = computed(() => store.getters.getTaskByTodoCount);
        const tasksByNotDone = computed(() => store.getters.tasksIsNotDone);
        const listStatus = computed(() => store.getters.allStatus)
        const isModalVisible = ref(false);
        const form = ref({ label: '', status_id: '' });

        onMounted(() => {
            store.dispatch('getTasksByTodo', route.params.id);
            store.dispatch('setTodo', route.params.id);
            store.dispatch('getListStatus');
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
                    store.dispatch('getTasksByTodo', route.params.id)
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

        const changeStatus = async (taskIndex) => {
            try {
                const taskId = todo.value.tasks.data[taskIndex].id;
                await store.dispatch('changeStatus', { id: taskId, status_id: form.value.status_id });
                notify({
                    title: "Deu certo",
                    text: "Task atualizado com sucesso",
                    type: "success",
                });
                await store.dispatch('getTasksByTodo', route.params.id);
                await store.dispatch('setTodo', route.params.id);

                modalStatusRef?.value?.[taskIndex]?.hideModal();
            } catch (error) {
                console.log(error)
                // notify({
                //     title: "Erro ao aualizar a tarefa",
                //     text: error.data.message,
                //     type: "danger",
                // });
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

                    store.dispatch('getTasksByTodo', route.params.id)
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

        const handleCloseModal = () => {
            isModalVisible.value = false
        }

        return {
            todo,
            todoCount,
            form,
            addTask,
            destroyTask,
            tasksByNotDone,
            listStatus,
            setDone,
            changeStatus,
            loading,
            getTagColorClass,
            modalStatusRef,
            isModalVisible,
            handleCloseModal
        };
    },
}
</script>
  