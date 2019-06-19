import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loggedIn: false,
    email: ""
  },
  mutations: {
    loginStatus(state, status, email) {
      state.loggedIn = status
      state.email = email
    }
  },
  getters: {
    loggedIn: state => state.loggedIn,
    email: state => state.email
  },
  actions: {}
});
