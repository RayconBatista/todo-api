<template>
    <div>
        <div class="bg-gray-800 p-4 text-white mb-4">
            <h1 class="text-2xl font-bold">Dashboard</h1>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-blue-500 p-4 text-white">
                <h2 class="text-xl font-semibold">Quantidade Total</h2>
                <p class="text-3xl">{{ total }}</p>
            </div>

            <div class="bg-green-500 p-4 text-white">
                <h2 class="text-xl font-semibold">Quantidade de Grupos</h2>
                <p class="text-3xl">{{ groups }}</p>
            </div>

            <div class="bg-yellow-500 p-4 text-white">
                <h2 class="text-xl font-semibold">Quantidade de Projetos</h2>
                <p class="text-3xl">{{ projects }}</p>
            </div>
        </div>
    </div>
</template>
<script>
import { computed } from 'vue';
import { useStore } from 'vuex';
export default {
    setup() {
        const store = useStore();
        const total = computed(() => store.state.todos.meta.total);
        const groups = 30;
        const projects = 50;

        return {
            total,
            groups,
            projects
        }
    }
}
</script>