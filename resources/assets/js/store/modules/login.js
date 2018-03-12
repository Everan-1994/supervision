import JWT from '../../helpers/jwt';

export default {
    actions: {
        loginRequest ({ dispatch }, formData) {
            return axios.post('/api/authorizations', formData).then(response => {
                if (response.status == 201) {
                    JWT.setToken(response.data.meta.access_token);
                    dispatch('setAuthUser', response.data);
                }
            }).catch(error => {
                console.log(error);
            });
        },
        logoutRequest({ dispatch }) {
            axios.post('/api/logout').then(response => {
                JWT.removeToken();
                dispatch('unsetAuthUser');
            })
        }
    }
}