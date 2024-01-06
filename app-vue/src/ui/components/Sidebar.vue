<template>
    <ul class="space-y-2 font-medium" v-for="(item, index) in sidebar" :key="index">
        <li>
            <router-link :to="{ name: item.to }" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                <i :class="item.icon"></i>
                <span class="ml-3">{{ item.title }}</span>
            </router-link>
        </li>
    </ul>
</template>

<script>
import {useStore} from "vuex";
import {onMounted, ref} from "vue";
import router from "@/router";
import sidebar from '@/infra/configs/sidebar.js';

export default {
    name: "Sidebar",
    setup() {
        const store     = useStore();
        const loading   = ref(false);

        onMounted(() => {
            sidebar.menu
        })

        const logout = () => {
            loading.value = true
            store.dispatch('logout')
                .then(() => router.push({ name: 'login' }))
                .finally(() => loading.value = false)
        }

        return {
            logout,
            sidebar: sidebar.menu
        }
    }
}
</script>

<style scoped>

</style>
