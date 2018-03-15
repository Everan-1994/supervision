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
    getAuthUser () {
        return JSON.parse(window.localStorage.getItem('vuex'));
    },
    removeAuthUser () {
        window.localStorage.removeItem('vuex');
    }
}