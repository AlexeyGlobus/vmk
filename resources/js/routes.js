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
            component: HomePage
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
/*        {
           path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/bulletin/:id',
            props: true,
            name: 'bulletin',
            component: Bulletin
        },
        {
            path: '/create',
            name: 'create',
            component: Create
        },
        {
            path: '/list',
            name: 'list',
            component: List
        },
        {
            path: '/orders',
            name: 'orders',
            component: Orders
        }*/
    ],
    mode: "history"
});