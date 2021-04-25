// import { createApp } from 'vue'
import { createStore } from 'vuex'

export const store = createStore({
  state () {
    return {
      auth: {
        user: null,
      }
    }
  },
  mutations: {
    setAuth (state, payload) {
      state.auth.user = payload.user
    }
  },

})