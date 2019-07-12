import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loggedIn: false,
    email: '',
    projects:[]
  },
  mutations: {
    loginStatus(state, status, email, pubkey) {
      state.loggedIn = status
      state.email = email
      state.pubkey = pubkey
    },
    addProject(state, newObj) {
      state.projects[newObj.id] = newObj
    }
  },
  getters: {
    loggedIn: state => state.loggedIn,
    email: state => state.email,
    projects: state => state.projects,
    pubkey: state => state.pubkey
  },
  actions: {}
});
