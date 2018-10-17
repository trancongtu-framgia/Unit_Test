
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VueRouter from 'vue-router'
import router from './routers'
// import 'bootstrap'
// import 'bootstrap/dist/css/bootstrap.min.css'
import { store } from './store/store'
import axios from 'axios'

window.Vue = require('vue');
Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.loggedIn) {
            next({
                name: 'login',
            })
        } else {
            next()
        }
    } else if (to.matched.some(record => record.meta.requiresVisitor)) {
        if (store.getters.loggedIn) {
            next({
                name: 'todo',
            })
        } else {
            next()
        }
    } else {
        next()
    }
})

const app = new Vue({
    el: '#app',
    router,
    store: store
});
