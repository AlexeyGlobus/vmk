import 'es6-promise/auto'
import axios from 'axios'
require('./bootstrap');
import Vue from 'vue';

//import VueAuth                  from '@websanova/vue-auth/dist/v2/vue-auth.esm.js';

import VueAxios from 'vue-axios'

import VueRouter from 'vue-router';

import vuetify from './plugins/vuetify';

//import auth from './auth'

import router from './routes';

import App from './App.vue';

Vue.router = router
Vue.use(VueRouter)

//Vue.use(VueRouter);

// Set Vue globally
//window.Vue = Vue
// Set Vue router
/*Vue.router = router
Vue.use(VueRouter)
// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`
Vue.use(VueAuth, auth)*/

import HomePage from './components/site/HomePage.vue';

new Vue({
    router,
    vuetify,
    render: h => h(App)
}).$mount('#app');