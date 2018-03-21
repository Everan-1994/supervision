import vueRouter from 'vue-router';
import State from './helpers/jwt';

let routes = [
    {
        path: '/403',
        name: '403',
        component: require('./components/errors/Error-403')
    },
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
    {
        path: '/system',
        component: require('./components/pages/System'),
        meta: { requireAuth: true },
        children: [
            {
                path: '',
                name: 'configures',
                component: require('./components/pages/systems/Configures'),
                meta: { requireAuth: true }
            },
            {
                path: '/departments',
                name: 'departments',
                component: require('./components/pages/systems/Departments'),
                meta: { requireAuth: true }
            },
            {
                path: '/notices',
                name: 'notices',
                component: require('./components/pages/systems/Notices'),
                meta: { requireAuth: true }
            }
        ]
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