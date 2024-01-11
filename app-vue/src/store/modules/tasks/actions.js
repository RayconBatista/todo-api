import DashboardService from "@/infra/services/dashboard.service";
export default ({
  async getTasks({ commit }) {
    await DashboardService
      .getTasks()
      .then(response => {
        commit('ADD_TASKS', response.data)
      })
  },
  
});