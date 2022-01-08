import VueRouter from 'vue-router'

/*let HistoryPage = require('./pages/History.vue');
let CardPage = require('./pages/Card.vue');
let PhotoBookPage = require('./pages/PhotoBook.vue');
let PhotoBookEditPage = require('./pages/PhotoBookEdit.vue');
let CalendarA3Page = require('./pages/CalendarA3.vue');
let CalendarDesktopPage = require('./pages/CalendarDesktop.vue');
let CalendarCirclePage = require('./pages/CalendarCircle.vue');
let OrdersPage = require('./pages/Orders.vue');
let NotFound = require('./pages/NotFound.vue');*/

//const routerPrefix = document.querySelector('html').lang == 'ru-RU' ? '/ru' : '/en';

import HomePage from './components/site/HomePage.vue';
import Login from './components/site/Login.vue';
import PlaceView from './components/place/View.vue';
import PlaceForm from './components/place/Form.vue';

/*import Bulletin from './components/Bulletins/Bulletin.vue'
import Create from './components/Bulletins/Create.vue'
import List from './components/Bulletins/List.vue'
import Login from './components/Auth/Login.vue'
import Register from './components/Auth/Register.vue'
import Orders from './components/User/Orders.vue'*/

export default new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomePage,
            meta: {
                auth: true
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/places/:id(\\d+)',
            name: 'PlaceView',
            component: PlaceView,
            meta: {
                auth: true
            }
        },
        {
            path: '/places/create',
            name: 'PlaceAdd',
            component: PlaceForm,
            meta: {
                auth: true
            }
        },
        {
            path: '/places/edit/:id',
            name: 'PlaceEdit',
            component: PlaceForm,
            meta: {
                auth: true
            }
        },
/*        {
           path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/create',
            name: 'create',
            component: Create
        },
*/
    ],
    mode: "history"
});