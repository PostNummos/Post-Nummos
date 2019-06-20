import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loggedIn: false,
    email: "",
    projects:[]
  },
  mutations: {
    loginStatus(state, status, email) {
      state.loggedIn = status
      state.email = email
    },
    addProject(state, newObj) {
      state.projects[newObj.id] = newObj
    }
  },
  getters: {
    loggedIn: state => state.loggedIn,
    email: state => state.email,
    projects: state => state.projects
  },
  actions: {}
});
