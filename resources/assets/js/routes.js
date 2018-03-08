import vueRouter from 'vue-router';

let routes = [
    {
        path: '/',
        name: 'index',
        component: require('./components/pages/Home')
    },
    {
        path: '/login',
        name: 'login',
        component: require('./components/login/Login')
    },
    {
        path: '/register',
        name: 'register',
        component: require('./components/register/Register')
    },
];

const router = new vueRouter({
    // mode: 'history',
    routes
});

export default router;