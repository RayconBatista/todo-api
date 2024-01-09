import { createStore } from "vuex";

import users from './modules/users';
import projects from './modules/projects';
import todos from './modules/todos';
import statuses from './modules/statuses';
import tasks from './modules/tasks';

export default createStore({
    modules: {
        users,
        statuses,
        projects,
        todos,
        tasks
    }
})
