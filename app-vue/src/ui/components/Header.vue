<template>
    <header>
        <div class="flex justify-between dark:bg-gray-800 rounded-lg p-4 mb-2">
            <ol class="flex text-gray-600 list-reset">
                <li>
                    <router-link to="/home" class="text-gray-600 dark:text-white">Home</router-link>
                </li>
                <li class="mx-2">/</li>
                <li>
                    <router-link :to="{ name: routeName }" class="text-gray-600 dark:text-white">{{ title }}</router-link>
                </li>
                <li class="mx-2" v-if="data">/</li>
                <li v-if="data">
                    <router-link :to="{ name: routeName, params: { id: data?.id } }" class="text-gray-600 dark:text-white">
                        {{ data?.name ? data?.name : data?.label }}
                    </router-link>
                </li>
            </ol>
        </div>
    </header>
</template>
<script>
export default {
    name: "Header",
    props: {
        title: {
            type: String,
            default: "Dashboard",
        },
        routeName: {
            type: String,
            default: ""
        },
        data: {
            type: Object,
            default: null
        }
    },
    setup(props) {
        // Não é necessário retornar 'title' aqui
    }
};
</script>


<style scoped></style>
