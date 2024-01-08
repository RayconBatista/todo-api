<template>
    <div class="container">
        <Header title="Dashboard" />
        <div
            class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">
            <!-- <div class="flex justify-between mb-2">
                <ol class="flex text-gray-600 list-reset">
                    <li>
                        <router-link to="/home" class="dark:text-white">Home</router-link>
                    </li>
                    <li class="mx-2">/</li>
                    <li>
                        <router-link :to="{ name: 'home' }" class="dark:text-white">Dashboard</router-link>
                    </li>
                </ol>
            </div> -->

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-500 p-4 text-white">
                    <h2 class="text-xl font-semibold">Quantidade Todos</h2>
                    <p class="text-3xl">{{ totalTodos }}</p>
                </div>

                <div class="bg-green-500 p-4 text-white">
                    <h2 class="text-xl font-semibold">Quantidade de Grupos</h2>
                    <p class="text-3xl">{{ groups }}</p>
                </div>

                <div class="bg-yellow-500 p-4 text-white">
                    <h2 class="text-xl font-semibold">Quantidade de Projetos</h2>
                    <p class="text-3xl">{{ totalprojects }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import Header from '../../components/Header.vue';
export default {
    components: {
        Header
    },
    setup() {
        const store = useStore();
        const totalTodos = computed(() => store.getters.getTodoTotal);
        const totalprojects = computed(() => store.getters.getProjectTotal);
        const groups = 30;

        onMounted(() => {
            store.dispatch('getTodos');
            store.dispatch('getProjects');
        });
        
        return {
            totalTodos,
            groups,
            totalprojects
        }
    }
}
</script>