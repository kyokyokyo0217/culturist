const state = {
  selectedChip: 'music',
}

const getters = {
  selectedChip: state => state.selectedChip
}

const mutations = {
  selectChip (state, chip) {
    state.selectedChip = chip
  }
}

const actions = {

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
