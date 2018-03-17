import Vue from 'vue';
import Vuex from 'vuex';

import createPersistedState from 'vuex-persistedstate';

import AuthUser from './modules/auth-user';
import Menu from './modules/menu';

Vue.use(Vuex);

export default new Vuex.Store({
    plugins: [createPersistedState()],
    modules: {
        AuthUser,
        Menu
    }
});
