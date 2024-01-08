export default ({
  allProjects: state => state.projects,
  getProjectSelected: state => state.project,
  getProjectTotal: state => state.projects?.meta.total,
  getError: state => state?.error
});
