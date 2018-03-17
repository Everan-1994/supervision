import vueRouter from 'vue-router';
import State from './helpers/jwt';

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
    let AuthUser = State.getVuex().AuthUser;
    if (to.meta.requireAuth) {
        if (AuthUser.authenticated) {
            return next();
        } else {
            return next({name: 'login'});
        }
    }
    if (to.meta.requireGuest) {
        if (AuthUser.authenticated) {
            return next({name: 'index'});
        } else {
            return next();
        }
    }
    next();
});

export default router;