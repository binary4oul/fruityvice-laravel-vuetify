import * as types from '../mutation-types'

/* Initial state */
export const state = {
  projectDetail: null,
  projectDetailStyles: null
}

export const mutations = {
  [types.SET_PROJECTDETAIL](state, { project_detail }) {
    state.projectDetail = project_detail
  },
  [types.SET_PROJECTDETAILSTYLES](state, { project_detail_styles }) {
    state.projectDetailStyles = project_detail_styles
  },
}
export const actions = {
  setProjectDetail({ commit }, payload) {
      commit(types.SET_PROJECTDETAIL, payload)
  },
  setProjectDetailStyles({ commit }, payload) {
    commit(types.SET_PROJECTDETAILSTYLES, payload)
  },
}

export const getters = {
  projectDetail: state => state.projectDetail,
  projectDetailStyles: state => state.projectDetailStyles,
  check: state => state.project !== null,
}
