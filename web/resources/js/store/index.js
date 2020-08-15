import Vue from 'vue'
import Vuex from 'vuex'

import auth from '@/store/auth'
import track from '@/store/track'
import selectChip from '@/store/selectChip'
import error from '@/store/error'

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
