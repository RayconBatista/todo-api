export default ({
    getMe: state => state.user,
    getUsers: state => state.users,
    getMembersTotal: state => state.users?.meta.total,
});