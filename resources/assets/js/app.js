require('./bootstrap');

window.Vue = require('vue');

import vueRouter from 'vue-router';
import App from './components/App';
import router from './routes';
import store from './store/index';
import JWT from './helpers/jwt';
import NProgress from 'nprogress';

import iView from 'iview';
import 'iview/dist/styles/iview.css';

Vue.use(vueRouter);
Vue.use(iView);

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
    return Promise.reject(error);
});

Vue.component('app', App);

const app = new Vue({
    el: '#app',
    router,
    store
});
