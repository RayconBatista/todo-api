<template>
    <div class="container">
        <Header title="Projetos" />
        <div
            class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">
            <notifications position="top right" />

            <!-- <input id="inline-password" type="text" v-model="form.label" v-on:keyup.enter="addTask(todo.id)"
                class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 mb-4"> -->

            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-gray-700 dark:text-white bg-gray-800 border-b">Index</th>
                            <th class="px-4 py-2 text-gray-700 dark:text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-gray-700 dark:text-white bg-gray-800 border-b">Description</th>
                            <th class="px-4 py-2 text-gray-700 dark:text-white bg-gray-800 border-b">Ativo</th>
                            <th class="px-4 py-2 text-gray-700 dark:text-white bg-gray-800 border-b">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="project in projects"
                            :key="project?.id">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ project?.id }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ project?.name }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ project?.description }}
                            </th>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ project.active }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <router-link :to="{ name: 'projects.single', params: { id: project?.id } }"
                                    class="px-1 py-1 mr-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    Visualizar
                                </router-link>
                                <button @click.stop.prevent="destroyProject(project.id)"
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
<!-- <template>
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
                        <router-link :to="{ name: 'projects.index' }" class="dark:text-white">Projects</router-link>
                    </li>
                </ol>
            </div>

            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Index</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Usuário</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Description</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Active</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Ações</th>
                        </tr>
                    </thead>
                </table>
                <tbody>
                    <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="project in projects" :key="project.id">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ project.id }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ project.name }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ project?.user?.first_name }} {{ todo?.user?.last_name }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ project.description }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ project.active }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <button
                                class="px-1 py-1 mr-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                Visualizar
                            </button>
                            <button
                                class="px-1 py-1 font-bold text-white bg-red-500 rounded hover:bg-red-700">
                                Remover
                            </button>
                        </td>
                    </tr>
                </tbody>
            </div>
        </div>
    </div>
</template> -->
<script>
import { ref, onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import { useNotification } from "@kyvg/vue3-notification";
import Header from '@/ui/components/Header.vue';

export default {
    components: {
        Header
    },
    setup() {
        const store = useStore();
        const { notify } = useNotification();
        const projects = computed(() => store.state.projects.projects);
        const error = computed(() => store.state.todos.error)

        onMounted(() => {
            store.dispatch('getProjects');
        });

        const destroyProject = async (id) => {
            try {
                await store.dispatch('destroyProject', id);
            } catch (e) {
                console.log({ 'ERRORS': error.status })

            }
            // store.dispatch('getProjects');
        };

        return {
            projects,
            destroyProject
        }
    }
}
</script>