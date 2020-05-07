import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import track from './track'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    track
  }
})

export default store
