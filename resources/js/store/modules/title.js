import * as types from '../mutation-types'

/* Initial state */
export const state = {
    title: '',
}

export const mutations = {
    [types.SET_TITLE](state, { title }) {
        state.title = title
    },
}

export const actions = {
    setTitle({ commit }, payload) {
        commit(types.SET_TITLE, payload)
    },
}

export const getters = {
    title: state => state.title,
    check: state => state.title !== null,
}
