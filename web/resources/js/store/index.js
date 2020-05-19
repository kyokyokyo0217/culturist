import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import track from './track'
import selectChip from './selectChip'
import error from './error'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    track,
    selectChip,
    error
  }
})

export default store
