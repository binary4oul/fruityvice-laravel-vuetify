import * as types from '../mutation-types'

/* Initial state */
export const state = {
  person: null,
  phone: null,
  address: null,
}

export const mutations = {
  [types.SET_PERSON](state, { person }) {
      state.person = person
  },
  [types.SET_PHONE](state, { phone }) {
      state.phone = phone
  },
  [types.SET_ADDRESS](state, { address }) {
      state.address = address
  },
}

export const actions = {
  setPerson({ commit }, payload) {
      commit(types.SET_PERSON, payload)
  },
  setPhone({ commit }, payload) {
      commit(types.SET_PHONE, payload)
  },
  setAddress({ commit }, payload) {
      commit(types.SET_ADDRESS, payload)
  },
}

export const getters = {
  person: state => state.person,
  phone: state => state.phone,
  address: state => state.address,
}

