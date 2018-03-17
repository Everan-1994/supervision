export default {
    setToken(token) {
        window.localStorage.setItem('jwt_token', token);
    },
    getToken() {
        return window.localStorage.getItem('jwt_token');
    },
    removeToken() {
        window.localStorage.removeItem('jwt_token');
    },
    getVuex() {
        return JSON.parse(window.localStorage.getItem('vuex'));
    },
    removeVuex() {
        window.localStorage.removeItem('vuex');
    }
}