import { createStore } from "vuex";

import auth from './modules/auth';
import users from './modules/users';
import invites from './modules/invites';
import projects from './modules/projects';
import todos from './modules/todos';
import tasks from './modules/tasks';
import statuses from './modules/statuses';
import tasksByTodo from './modules/tasksByTodo';

export default createStore({
    modules: {
        auth,
        users,
        invites,
        statuses,
        projects,
        todos,
        tasks,
        tasksByTodo
    }
})
