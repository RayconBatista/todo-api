<template>
    <div class="container">
        <Header title="Meu perfil" />
        <div class="bg-white dark:bg-gray-800 rounded-md w-full p-4 shadow-md mb-4">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl mb-4">Meu perfil</h2>
            <div class="flex">
                <div class="mb-4 w-1/5">
                    <div>
                        <!-- Conteúdo do Card 1 -->

                        <!-- <div class="photo-wrapper p-2">
                            <img class="w-32 h-32 rounded-full" :src="auth.image_url" :alt="auth.name">
                        </div> -->
                    </div>
                </div>
                <div class="w-4/5">
                    <div>
                        <ul class="container">
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="name">
                                    Nome
                                </label>
                                <input 
                                    id="name" 
                                    type="text" 
                                    v-model="form.first_name"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                    :placeholder="auth.first_name"
                                >
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="last_name">
                                    Sobrenome
                                </label>
                                <input 
                                    id="last_name" 
                                    type="text" 
                                    v-model="form.last_name"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                    :placeholder="auth.last_name"
                                >
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="email">
                                    Email
                                </label>
                                <input 
                                    id="email" 
                                    type="text" 
                                    v-model="form.email"
                                    :placeholder="auth.email"
                                    disabled
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                >
                            </div>
                            <button 
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 float-right"
                                @click.prevent="updateMe(auth.id)"
                                type="button"
                            >
                                Salvar
                            </button>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, onMounted, reactive } from 'vue'
import { useStore } from 'vuex'
import Header from '../../components/Header.vue';
export default {
    name: "Profile",
    components: {
        Header
    },
    setup() {
        const store = useStore();
        const auth = computed(() => store.getters.getMe);
        const form = reactive({
            first_name: auth.value.first_name || '',
            last_name: auth.value.last_name || '',
            email: auth.value.email || '',
        })


        onMounted(() => {
            store.dispatch('users/getMe')
        });

        const updateMe = async (userId) => {
            const params = {
                id: userId,
                first_name: form.first_name,
                last_name: form.last_name,
                phone: form.phone,
            };
            await store.dispatch('users/updateMe', params);
        };

        return {
            auth,
            form,
            // subscriptionType,
            updateMe
        };
    },
}
</script>
