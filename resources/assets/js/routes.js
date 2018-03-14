import vueRouter from 'vue-router';
import Store from './store/modules/auth-user';

let routes = [
    {
        path: '/',
        name: 'index',
        component: require('./components/pages/Home')
    },
    {
        path: '/login',
        name: 'login',
        component: require('./components/login/Login'),
        meta: { requireGuest: true }
    },
    {
        path: '/register',
        name: 'register',
        component: require('./components/register/Register'),
        meta: { requireGuest: true }
    },
    {
        path: '/profile',
        name: 'profile',
        component: require('./components/users/Profile'),
        meta: { requireAuth: true }
    },
];

const router = new vueRouter({
    // mode: 'history',
    routes
});

router.beforeEach((to, form, next) => {
    if (to.meta.requireAuth) {
        if (Store.state.authenticated) {
            return next();
        } else {
            return next({name: 'login'});
        }
    }
    if (to.meta.requireGuest) {
        if (Store.state.authenticated) {
            return next({name: 'index'});
        } else {
            return next();
        }
    }
    next();
});

export default router;