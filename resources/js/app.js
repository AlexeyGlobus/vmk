import 'es6-promise/auto';
import axios from 'axios';
import './bootstrap';
import Vue from 'vue';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';

import VueAuth                  from '@websanova/vue-auth/dist/v2/vue-auth.esm.js';
import driverAuthBearer      from '@websanova/vue-auth/dist/drivers/auth/bearer.esm.js';
import driverHttpAxios       from '@websanova/vue-auth/dist/drivers/http/axios.1.x.esm.js';
import driverRouterVueRouter from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x.esm.js';

import router from './routes';
import vuetify from './plugins/vuetify';

// Set Vue globally
window.Vue = Vue
// Set Vue router
Vue.router = router
Vue.use(VueRouter)
// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`
//axios.defaults.baseURL = 'http://192.168.10.10/api'

const authConfig = {
    plugins: {
        http: Vue.axios, // Axios
        // http: Vue.http, // Vue Resource
        router: Vue.router,
    },
    drivers: {
        auth: driverAuthBearer,
        http: driverHttpAxios,
        router: driverRouterVueRouter,
    },
    options: {
      rolesVar: 'role',
      rolesKey: 'type',
      notFoundRedirect: {name: 'user-account'},
      registerData: {url: 'auth/register', method: 'POST', redirect: '/login'},
      loginData: {url: 'auth/login', method: 'POST', redirect: '', fetchUser: true},
      logoutData: {url: 'auth/logout', method: 'POST', redirect: '/', makeRequest: true},
      fetchData: {url: 'auth/user', method: 'GET', enabled: true},
      refreshData: {url: 'auth/refresh', method: 'GET', enabled: true, interval: 30}
    }
};

Vue.use(VueAuth, authConfig)

import App from './App.vue';

new Vue({
    router,
    vuetify,
    render: h => h(App)
}).$mount('#app');