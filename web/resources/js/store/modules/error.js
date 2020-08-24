const state = {
    code: null
}

const mutations = {
    setCode(state, code) {
        state.code = code
    },
}

const actions = {
    setCode(context, data) {
        context.commit('setCode', data)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
