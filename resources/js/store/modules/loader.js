import * as types from '../mutation-types'

/* Initial state */
export const state = {
    loader: false,
}

export const mutations = {
    [types.SET_LOADER](state, { loader }) {
        state.loader = loader
    },
}

export const actions = {
    setLoader({ commit }, payload) {
        commit(types.SET_LOADER, payload)
    },
}

export const getters = {
    loader: state => state.loader,
    check: state => state.loader !== null,
}
