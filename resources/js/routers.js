import VueRouter from 'vue-router'
import Login from './components/LoginComponent.vue'
import Logout from './components/LogoutComponent.vue'

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
    }

]

export default new VueRouter({
    routes
})
