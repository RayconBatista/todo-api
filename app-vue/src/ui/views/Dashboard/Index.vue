<template>
    <div class="container">
        <Header title="Dashboard" />
        <div v-if="loading"
            class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">
            <div class="grid grid-cols-3 gap-4">
                <CardDash title="Quantidade Todos" color="blue" :dataCount="totalTodos"/>
                <CardDash title="Quantidade de Membros" color="green" :dataCount="totalMembers"/>
                <CardDash title="Quantidade de Projetos" color="yellow" :dataCount="totalprojects"/>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <PieChart :data="tasks" title="Tarefas" />
            </div>
        </div>
        <div v-else>Carregando....</div>
    </div>
</template>
<script>
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import Header from '../../components/Header.vue';
import CardDash from '../../components/CardDash.vue';
import PieChart from '../../components/Charts/Pie.vue';
export default {
    components: {
        Header,
        CardDash,
        PieChart
    },
    setup() {
        const store = useStore();
        const loading = computed(() => store.state.auth.loading)
        const totalTodos = computed(() => store.getters.getTodoTotal);
        const totalprojects = computed(() => store.getters.getProjectTotal);
        const totalMembers = computed(() => store.getters.getMembersTotal);
        const tasks = computed(() => store.getters.allTasks);

        onMounted(async () => {
            await store.dispatch('getTodos');
            await store.dispatch('getTasks');
            await store.dispatch('getProjects');
            await store.dispatch('getUsers');
        });
        
        return {
            totalTodos,
            totalMembers,
            totalprojects,
            tasks,
            loading
        }
    }
}
</script>