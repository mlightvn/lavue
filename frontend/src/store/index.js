import { createStore } from 'vuex'
import auth from './auth'

export default createStore({
  modules: {
    auth,
  },

  state () {
    // return {
    //   auth: {
    //     user: null,
    //   }
    // }
  },
  mutations: {
    // setAuth (state, payload) {
    //   state.auth.user = payload.user
    // }
  },

})