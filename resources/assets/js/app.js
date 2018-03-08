require('./bootstrap');

window.Vue = require('vue');

import vueRouter from 'vue-router';
import App from './components/App';
import router from './routes';
import iView from 'iview';
import 'iview/dist/styles/iview.css';

Vue.use(vueRouter);
Vue.use(iView);

// 请求拦截器
axios.interceptors.request.use(function (config) {
    // config.headers['Authorization'] = 'Bearer ' + JWT.getToken();
    return config;
}, function (error) {
    return Promise.reject(error);
});

Vue.component('app', App);

const app = new Vue({
    el: '#app',
    router
});
