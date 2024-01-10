export default ({
    getUsers: state => state.users,
    getMembersTotal: state => state.users?.meta.total,
});