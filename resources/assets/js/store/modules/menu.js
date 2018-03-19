import * as types from '../mutation-type';

export default {
    state: {
        activeMenu: null,
        childMenu: null,
    },
    mutations: {
        [types.SET_MENU](state, payload) {
            state.activeMenu = payload.menu.activeMenu;
            state.childMenu = payload.menu.childMenu;
        },
    },
    actions: {
        setMenu ({ commit }, menu) {
            commit({
                type: types.SET_MENU,
                menu: menu
            });
        }
    }
}