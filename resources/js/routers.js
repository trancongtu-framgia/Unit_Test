import VueRouter from 'vue-router'
import Login from './components/LoginComponent.vue'
import Logout from './components/LogoutComponent.vue'
import Welcome from './components/Welcome.vue'
import RegisterAccount from './components/RegisterAccountComponent'
import Home from './components/HomeComponent'
import Report from './components/layouts/reports/ReportComponent'
import Profile from './components/Profile.vue'
import Reports from './components/Reports.vue'
import ListWorkspace from './components/workspace/ListWorkspaceComponent'
import ListTeam from './components/team/ListTeam.vue'
import ListType from './components/type/ListType.vue'
import ListSubject from './components/subject/ListSubject.vue'
import Multiguard from 'vue-router-multiguard'
import RegisterTrainee from './components/trainee/register'
import Batch from './components/batch/Listbatches'
import AddBatch from './components/batch/Addbatch'
import EditBatch from './components/batch/Editbatch'
import User from './components/users/User.vue'
import axios from 'axios';

const getUser = () => {
    axios.defaults.headers.common['Authorization'] =
        'Bearer ' + localStorage.getItem('access_token');

    return axios.get('current-user');
}

let user = null;

const isAdmin = async (to, form, next) => {
    if (user === null) await getUser().then(res => {
        user = res.data.data;
    });
    if (user) {
        if (user.role !== 'trainee') {
            next();
        } else {
            next({
                name: 'index'
            });
        }
    };
}

let routes = [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register-account-trainee',
        name: 'register-account-trainee',
        component: RegisterTrainee,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    },
    {
        path: '/logout',
        name: 'logout',
        component: Logout,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/',
        name: 'index',
        component: Welcome,
        meta: {
            requiresAuth: true
        }
    },

    {
        path: '/manager-report',
        name: 'manager_report',
        component: Report,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/reports',
        name: 'reports',
        component: Reports,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    },
    {
        path: '/workspace',
        name: 'list_workspace',
        component: ListWorkspace,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    },
    {
        path: '/teams',
        name: 'list_team',
        component: ListTeam,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    },
    {
        path: '/types',
        name: 'list_type',
        component: ListType,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    },
    {
        path: '/subjects',
        name: 'list_subjects',
        component: ListSubject,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    },
    {
        path: '/batches',
        name: 'list_batches',
        component: Batch,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    },
    {
        path: '/batches/add',
        name: 'add_batches',
        component: AddBatch,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    },
    {
        path: '/batches/edit/:id',
        name: 'edit_batches',
        component: EditBatch,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    },
    {
        path: '/manager-users',
        name: 'manager-users',
        component: User,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    }
];

export default new VueRouter({
    routes
});
