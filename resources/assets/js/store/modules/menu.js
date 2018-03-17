import * as types from '../mutation-type';

export default {
    state: {
        activeMenu: null,
    },
    mutations: {
        [types.SET_MENU](state, payload) {
            state.activeMenu = payload.menu;
        },
    },
    actions: {
        setMenu ({ commit }, activeMenu) {
            commit({
                type: types.SET_MENU,
                menu: activeMenu
            });
        }
    }
}