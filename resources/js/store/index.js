import Vue from 'vue'
import 'es6-promise/auto'
import Vuex from 'vuex'

import auth from './auth'

Vue.use(Vuex)

export default new Vuex.Store({
  cache : false,
  state: {
  },
  mutations: {
  },
  actions: {
  },
  modules: {
    auth
  }
})
