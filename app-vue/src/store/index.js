import { createStore } from "vuex";

import users from './modules/users';
import todos from './modules/todos';
import tasks from './modules/tasks';

export default createStore({
    modules: {
        users,
        todos,
        tasks
    }
})
