import Vuex from 'vuex'
import Vue from 'vue'
import {routes} from '../router'

import {RepositoryFactory} from '../repository/RepositoryFactory'

const AuthRepository = RepositoryFactory.get('users');
Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        userId: null,
        email: null,
        username: null
    },
    mutations: {
        authUser(state, userData) {
            state.email = userData.email;
            state.userId = userData.userId;
            state.username = userData.username;
        },
        clearAuthData(state) {
            state.email = null;
            state.id = null;
            state.username = null;
        },
    },
    actions: {
        logout({commit}) {
            commit('clearAuthData');
        },
        loggedUser({commit, dispatch}, authData) {
            commit('authUser', {
                email: authData.user.email,
                userId: authData.user.id,
                username: authData.user.username,
            });
        },
    }

})
