require('./bootstrap');

window.Vue = require('vue');

import vueRouter from 'vue-router';
import App from './components/App';
import router from './routes';
import store from './store/index';
import JWT from './helpers/jwt';

import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

import iView from 'iview';
import 'iview/dist/styles/iview.css';

Vue.use(vueRouter);
Vue.use(iView);

// 禁用进度环
NProgress.configure({ showSpinner: false });

// 请求拦截器
axios.interceptors.request.use(function (config) {
    config.headers['Authorization'] = 'Bearer ' + JWT.getToken();
    NProgress.start();
    return config;
}, function (error) {
    return Promise.reject(error);
});

// 添加一个返回拦截器
axios.interceptors.response.use((response) => {
    // 请求结束，蓝色过渡滚动条消失
    NProgress.done();
    return response;
}, (error) => {
    // 请求结束，蓝色过渡滚动条消失
    NProgress.done();
    if (error.response.status == 403) {
        router.push({name: '403'});
    }
    if (error.response.status == 401) {
        axios.get('/api/authorizations/curren').then(response => {
            JWT.setToken(response.data.meta.access_token);
            store.dispatch('setAuthUser', response.data);
        }).catch(() => {
            JWT.removeToken();
            store.dispatch('unsetAuthUser');
            this.$Message.warning({
                content: '身份信息已过期，请重新登陆。',
                duration: 2,
                onClose: () => {
                    router.push({name: 'login'});
                }
            });
        });
    }
    return Promise.reject(error);
});

Vue.component('app', App);

const app = new Vue({
    el: '#app',
    router,
    store
});
