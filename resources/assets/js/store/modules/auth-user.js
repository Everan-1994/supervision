import * as types from '../mutation-type';

export default {
    state: {
        authenticated: null,
        username: null,
        email: null,
    },
    mutations: {
        [types.SET_AUTH_USER](state, payload) {
            state.authenticated = true;
            state.username = payload.user.name;
            state.email = payload.user.email;
        }
    },
    actions: {
        setAuthUser ({ commit }, userInfo) {
            commit({
                type: types.SET_AUTH_USER,
                user: userInfo
            });
        },
    }
}