import VueRouter from 'vue-router';
import Login from './components/LoginComponent.vue';
import Logout from './components/LogoutComponent.vue';
import Master from './components/Welcome.vue';

let routes = [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/logout',
        name: 'logout',
        component: Logout
    },
    {
        path: '/',
        name: 'index',
        component: Master
    }
];

export default new VueRouter({
    routes
});
