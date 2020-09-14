import axios from 'axios'
import { api } from '~/config'
import * as types from '../mutation-types'

/* Initial state */
export const state = {
    project: null,
}

export const mutations = {
    [types.SET_PROJECT](state, { project }) {
        state.project = project
    },
}
export const actions = {
    setProject({ commit }, payload) {
        commit(types.SET_PROJECT, payload)
    },
}

export const getters = {
    project: state => state.project,
    check: state => state.project !== null,
}
