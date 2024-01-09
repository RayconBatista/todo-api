<template>
  <div class="container">
    <notifications position="top right" />
    <Header title="Projetos" :data="project" />

    <div class="flex justify-between">
      <div
        class="w-3/4 p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full mr-2">
        <div class="mt-4">
          <div class="px-4 sm:px-0 flex justify-between">
            <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white text-left uppercase">Informações
            </h3>
            <button class="text-gray-900 dark:text-white">
              <i class="fa-solid fa-heart"></i>
            </button>
          </div>

          <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
              <div class="px-4 py-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Nome</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-white col-span-2 text-left">{{ project?.name }}
                </dd>
              </div>
              <div class="px-4 py-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Descrição</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-white col-span-2 text-left">{{
                  project?.description }}</dd>
              </div>
              <div class="px-4 py-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Prioridade</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-white col-span-2 text-left">{{ project?.priority
                }}</dd>
              </div>

              <div class="px-4 py-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Tags</dt>
                <div class="flex flex-wrap col-span-2">
                  <span v-for="tag in project?.tags" :key="tag?.id"
                    class="text-sm mb-2 mr-3 w-[100px] leading-6 inline-flex justify-center font-bold uppercase px-3 dark:text-white rounded-full"
                    :style="`background-color: ${tag?.color}`">
                    {{ tag.label }}
                  </span>
                </div>
              </div>

              <!-- Other sections remain unchanged -->

            </dl>
          </div>

        </div>
      </div>
      <div
        class="w-1/4 p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">
        <div class="px-4 sm:px-0 flex justify-between">
          <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white text-left uppercase">Membros</h3>
          <Modal ref="modalRef" title="Adicionar" :acceptFunction="addMember" @close-modal="handleCloseModal">
            <select v-model="form.user_id"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option selected disabled>Selecionar membro</option>
              <option v-for="member in users" :key="member?.id" :value="member.id">
                {{ member.first_name }} {{ member.last_name }} - [{{ member.email }}]
              </option>
            </select>
          </Modal>
        </div>

        <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
          <li class="mb-2 pb-3 pt-3 sm:pb-2 sm:pt-4" v-for="member in project?.users" :key="member?.id">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
              <!-- <div class="flex-shrink-0">
                <img class="w-8 h-8 rounded-full" src="#" alt="Neil image">
              </div> -->
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate dark:text-white text-left">
                  {{ member.first_name }} {{ member.last_name }}
                </p>
                <p class="text-sm text-gray-500 truncate dark:text-gray-400 text-left">
                  {{ member.email }}
                </p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div
      class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full mt-4">
      <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                Index
              </th>
              <th scope="col" class="px-6 py-3">
                Nome
              </th>
              <th scope="col" class="px-6 py-3">
                Tarefas
              </th>
              <th scope="col" class="px-6 py-3">
                Criado por
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="todo in project?.todos"
              :key="todo.id">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ todo?.id }}
              </th>
              <td class="px-6 py-4">
                {{ todo?.label }}
              </td>
              <td class="px-6 py-4">
                <!-- {{ todo?.tasks.length }} -->
                {{ `${todo?.tasks.data.filter(t => t.is_completed == 1).length} / ${todo?.tasks.length}` }}
              </td>
              <td class="px-6 py-4">
                {{ todo?.user?.first_name }}
                {{ todo?.user?.last_name }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
  
<script>
import { onMounted, computed, ref, getCurrentInstance  } from 'vue';
import { useStore } from 'vuex';
import { useRoute, useRouter } from 'vue-router';
import { useNotification } from "@kyvg/vue3-notification";
import Header from '@/ui/components/Header.vue';
import Modal from '../../../components/Modal.vue';
import ProjectService from '@/infra/services/projects.service'

export default {
  name: "Project",
  components: {
    Header,
    Modal
  },
  emits: ['close-modal'],
  setup(props, context) {
    const store = useStore();
    const route = useRoute();
    const router = useRouter();
    const modalRef = ref(null);
    const loading = ref(false);
    const { notify } = useNotification();
    const form = ref({user_id: ''});
    const users = computed(() => store.state.users.users)
    const project = computed(() => store.getters.getProjectSelected);
    const isModalVisible = ref(false);
    
    onMounted(() => {
      store.dispatch('getUsers');
      store.dispatch('setProject', route.params.id)
    });

    const addMember = () => {
      ProjectService.addMember(route.params.id, {user_id: form.value.user_id}).then(() => {
        notify({
          title: "Deu certo",
          text: "Membro adicionado com sucesso",
          type: "success",
        });
        store.dispatch('setProject', route.params.id);
        modalRef.value.hideModal();
        form.value.user_id = '';
      });
    }

    const handleCloseModal = () => {
      isModalVisible.value = false
    }

    const getTagColorClass = (color) => {
      if (color) {
        return `bg-[${color}]`;
      }
      return 'text-gray-700';
    }

    return {
      users,
      form,
      project,
      loading,
      modalRef,
      getTagColorClass,
      addMember,
      handleCloseModal,
    };
  },
}
</script>
  