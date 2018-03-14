import * as types from '../mutation-type';

export default {
    state: {
        authenticated: false,
        department: null,
        username: null,
        sex: null,
    },
    mutations: {
        [types.SET_AUTH_USER](state, payload) {
            state.authenticated = true;
            state.department = payload.user.department;
            state.username = payload.user.name;
            state.sex = payload.user.sex;
        },
        [types.UNSET_AUTH_USER](state) {
            state.authenticated = false;
            state.department = null;
            state.username = null;
            state.sex = null;
        },
    },
    actions: {
        setAuthUser ({ commit }, userInfo) {
            commit({
                type: types.SET_AUTH_USER,
                user: userInfo
            });
        },
        unsetAuthUser ({ commit }) {
            commit({
                type: types.UNSET_AUTH_USER
            });
        },
    }
}