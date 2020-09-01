import axios from 'axios'
import { api } from '~/config'
import * as types from '../mutation-types'

/* Initial state */
export const state = {
    leaddetail: null,
}

export const mutations = {
    [types.SET_LEADDETAIL](state, { leaddetail }) {
        state.leaddetail = leaddetail
    },
}

export const actions = {
    setLeaddetail({ commit }, payload) {
        commit(types.SET_LEADDETAIL, payload)
    },
}

export const getters = {
    leaddetail: state => state.leaddetail,
    check: state => state.leaddetail !== null,
}
