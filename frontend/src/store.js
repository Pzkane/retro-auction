import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    loginButtonClicked: false,
    isLogged: false,
    addOfferDialog: false,

    charityTotal: 0,
    commercialTotal: 0
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
    },
    setCharityTotal (state, total) {
      state.charityTotal = total
    },
    setCommercialTotal (state, total) {
      state.commercialTotal = total
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
    },
    charityTotal: state => state.charityTotal,
    commercialTotal: state => state.commercialTotal
  },
  actions: {

  }
})
