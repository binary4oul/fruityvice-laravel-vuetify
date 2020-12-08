import axios from 'axios'
import { api } from '~/config'
import * as types from '../mutation-types'

/**
 * Initial state
 */
export const state = {
  user: null,
  token: window.localStorage.getItem('token').anchor,
  team_role : 'manager'
}

/**
 * Mutations
 */
export const mutations = {
  [types.SET_USER](state, { user }) {
    state.user = user
  },

  [types.LOGOUT](state) {
    state.user = null
    state.token = null
  },

  [types.FETCH_USER_FAILURE](state) {
    state.user = null
  },

  [types.SET_TOKEN](state, { token }) {
    state.token = token
  },

  [types.SET_TEAM_ROLE](state, { team_role }) {
    state.team_role = team_role
  }
}

/**
 * Actions
 */
export const actions = {
  saveToken({ commit }, payload) {
    commit(types.SET_TOKEN, payload)
  },

  async fetchUser({ commit }) {
    try {
      const { data } = await axios.get(api.path('me'))
      commit(types.SET_USER, data)
    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  setUser({ commit }, payload) {
    commit(types.SET_USER, payload)
  },

  setTeamRole({ commit }, payload) {
    commit(types.SET_TEAM_ROLE, payload)
  },

  async logout({ commit }) {
    await axios.post(api.path('logout'))
    commit(types.LOGOUT)
  },

  destroy({ commit }) {
    commit(types.LOGOUT)
  }
}

/**
 * Getters
 */
export const getters = {
  user: state => state.user,
  check: state => state.user !== null,
  token: state => state.token,
  team_role: state => state.team_role
}
