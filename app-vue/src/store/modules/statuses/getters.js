export default ({
  allStatus        : state => state.statuses,
  getStatusSelected : state => state.status,
  getStatusTotal    : state => state.statuses?.meta.total,
});
  