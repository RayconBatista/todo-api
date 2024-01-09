import StatusService from "@/infra/services/status.service";

export default ({
  async getListStatus({ commit }) {
    try {
      const response = await StatusService.getStatuses();
      commit('ADD_STATUS', response.data);
    } catch (error) {
      // Lidar com erros, por exemplo, emitindo um commit de erro
      // commit('SET_ERROR', error.message);
      console.log(error.message)
    }
  },
});