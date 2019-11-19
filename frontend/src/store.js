import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    loginButtonClicked: false,
    isLogged: false
  },
  mutations: {
    fadeLogin: state => {
      state.loginButtonClicked = !state.loginButtonClicked
    },
    changeAuthState: state => {
      state.isLogged = !state.isLogged
    }
  },
  getters: {
    getLoginButton: state => {
      return state.loginButtonClicked
    },
    getAuthState: state => {
      return state.isLogged
    }
  },
  actions: {

  }
})
