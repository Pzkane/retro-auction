import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    loginButtonClicked: false,
    isLogged: false,
    addOfferDialog: false
  },
  mutations: {
    fadeLogin: state => {
      state.loginButtonClicked = !state.loginButtonClicked
    },
    changeAuthState: state => {
      state.isLogged = !state.isLogged
    },
    changeAppendOfferState: state => {
      state.addOfferDialog = !state.addOfferDialog
    }
  },
  getters: {
    getLoginButton: state => {
      return state.loginButtonClicked
    },
    getAuthState: state => {
      return state.isLogged
    },
    getAppendingOfferState: state => {
      return state.addOfferDialog
    }
  },
  actions: {

  }
})
