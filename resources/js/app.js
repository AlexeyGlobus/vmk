require('./bootstrap');
import Vue from 'vue';
import vuetify from './plugins/vuetify';
import router from './routes';
import VueRouter from 'vue-router';
import App from './App.vue';

Vue.use(VueRouter);

import HomePage from './components/site/HomePage.vue';

new Vue({
    router,
    vuetify,
    render: h => h(App)
}).$mount('#app');