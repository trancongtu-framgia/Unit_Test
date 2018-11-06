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
import Multiguard from 'vue-router-multiguard';
import axios from 'axios';

const getUser = () => {
    axios.defaults.headers.common['Authorization'] =
        'Bearer ' + localStorage.getItem('access_token');

    return axios.get('current-user');
}

const isAdmin = async (to, form, next) => {
    let user = null;
    await getUser().then(res => {
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
        component: RegisterAccount,
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
    }
];

export default new VueRouter({
    routes
});
