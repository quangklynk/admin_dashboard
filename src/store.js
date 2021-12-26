import Vue from 'vue'
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        user: null,
        role: null,
        id: null
    },
    getters: {
        user: (state) => {
            return state.user || localStorage.getItem('user');
        },
        role: (state) => {
            return state.role || localStorage.getItem('role');
        },
        id: (state) => {
            return state.id || localStorage.getItem('id');
        }
    },
    actions: {
        user(context, user) {
            context.commit('user', user);
        },
        role(context, role) {
            context.commit('role', role);
        },
        id(context, id) {
            context.commit('id', id);
        }
    },
    mutations: {
        user(state, user) {
            state.user = user;
        },
        role(state, role) {
            state.role = role;
        },
        id(state, id) {
            state.id = id;
        },
    }
});
