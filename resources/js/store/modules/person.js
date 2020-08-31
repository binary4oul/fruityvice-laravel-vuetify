import axios from 'axios'
import { api } from '~/config'
import * as types from '../mutation-types'

/* Initial state */
export const state = {
    person: null,
}

export const mutations = {
    [types.SET_PERSON](state, { person }) {
        state.person = person
    },
}

export const actions = {
    setPerson({ commit }, payload) {
        commit(types.SET_PERSON, payload)
    },
}

export const getters = {
    person: state => state.person,
    check: state => state.person !== null,
}

