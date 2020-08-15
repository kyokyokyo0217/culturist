const state = {
    nowPlaying: null,
}

const getters = {
    track: state => state.nowPlaying ? state.nowPlaying : '',
}

const mutations = {
    setNowPlaying(state, nowPlaying) {
        state.nowPlaying = nowPlaying
    }
}

const actions = {
    nowPlaying(context, data) {
        context.commit('setNowPlaying', data)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
