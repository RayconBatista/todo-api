<template>
    <div class="container">
        <Header title="Todos" />
        <div
            class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">

            <div class="flex items-end mb-4">
                <Modal ref="modalTodoRef" class="items-end ml-auto" title="Nova tarefa" :acceptFunction="addTodo"
                    @close-modal="handleCloseModal">
                    <!-- Conteúdo do modal aqui -->
                    <input type="text" v-model="form.label" v-on:keyup.enter="addTodo" placeholder="Tarefa"
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 mb-4">

                    <select v-model="form.project_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected disabled>Selecionar Projeto</option>
                        <option v-for="project in projects" :key="project?.id" :value="project.id">
                            {{ project.name }}
                        </option>
                    </select>
                </Modal>
            </div>

            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Index</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Usuário</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Projeto</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Tarefas</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="todo in todos" :key="todo.id">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                todo?.id }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                todo?.label }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                todo?.user?.first_name }} {{ todo?.user?.last_name }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                                todo?.project?.name }}</td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{

                                `${todo?.tasks?.data?.filter(t => t?.status?.id == 4)?.length || 0} / ${todo?.tasks?.length || 0}` }}
                            </td>
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
import Header from '../../components/Header.vue';
import Modal from '../../components/Modal.vue';
export default {
    name: "Todos",
    components: {
        Header,
        Modal
    },
    emits: ['close-modal'],
    setup(props, context) {
        const store = useStore();
        const modalTodoRef = ref(null);
        const todos = computed(() => store.state.todos.todos);
        const tasks = computed(() => store.state.tasks);
        const projects = computed(() => store.getters.allProjects);
        const { notify } = useNotification();
        const form = ref({ label: "", project_id: "" });
        const isModalVisible = false;

        onMounted(() => {
            store.dispatch('getTodos');
            store.dispatch('getProjects');
        });

        const getTodo = (id) => {
            store.dispatch('getTasks', id);
        }

        const addTodo = async () => {
            try {
                await store.dispatch('storeTodo', form.value).then(() => {
                    notify({
                        title: "Deu certo",
                        text: "Todo registrado com sucesso",
                        type: "success",
                    });
                    store.dispatch('getTodos');
                    modalTodoRef.value?.hideModal();
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

        const handleCloseModal = () => {
            isModalVisible.value = false
        }

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
            projects,
            todos,
            tasks,
            form,
            addTodo,
            getTodo,
            destroyTodo,
            modalTodoRef,
            handleCloseModal
        };
    }
};
</script>
  