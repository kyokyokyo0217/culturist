import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate";

import auth from '@store/modules/auth'
import track from '@store/modules/track'
import selectChip from '@store/modules/selectChip'
import error from '@store/modules/error'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        auth,
        track,
        selectChip,
        error
    },
    plugins: [createPersistedState()],
})

export default store
