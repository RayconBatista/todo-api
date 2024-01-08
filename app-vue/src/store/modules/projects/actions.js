import ProjectService from "../../../infra/services/projects.service";
import { useNotification } from "@kyvg/vue3-notification";

const { notify } = useNotification();

export default ({
  async getProjects({ commit }, id) {
    await ProjectService
      .getProjects()
      .then(response => {
        const { data, meta } = response.data;
        commit('ADD_PROJECTS', response.data)
        commit('REFRESH_PROJECTS', { data, meta })
      })
  },
  async setProject({ commit }, id) {
    await ProjectService
      .getProject(id)
      .then(response => {
        commit('SET_PROJECT', response.data)
      })
  },
  async destroyProject({ commit }, id) {
    await ProjectService
      .destroyProject(id)
      .then((response) => {
        if (response.data.status === 'success') {
          commit('DELETE_PROJECT', id)
          notify({
            title: "Deu certo",
            text: response.data.message,
            type: response.data.status,
          });
        } else {
          commit('ERROR', response.data)
          notify({
            title: "Ops!",
            text: response.data.message,
            type: response.data.status,
          });
        }
      })
      .catch((response) => {
        console.error('Erro ao deletar o projeto:', response)
      })
  },
});