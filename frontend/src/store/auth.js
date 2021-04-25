import axios from 'axios'


// ref: https://github.com/vuejs/vuex/blob/4.0/examples/classic/shopping-cart/store/modules/products.js


export default {
  namespaced: true,

  state: () => ({
    auth: {
      user: null,
    }
  }),

  // getters: {
  //   auth (state) {
  //     return state.auth
  //   },

  //   user (state) {
  //     return state.auth.user
  //   },
  // },

  mutations: {
    SET_AUTH ({state}, value) {
      // state.auth.user = value
      if(value){
        state.auth.user = value
        localStorage.setItem('user', JSON.stringify(value))
      }else{
        state.auth.user = null
        localStorage.removeItem('user')
      }

    },
  },


  actions: {
    async signIn ({ dispatch }, credentials) {
      console.log("auth, signIn")

      await axios.get('sanctum/csrf-cookie')
      let login_auth = await axios.post("login", credentials);
      console.log("login_auth")
      console.log(login_auth)

      dispatch('me')
    },

    async signOut ({ dispatch }) {
      await axios.post('logout', null)

      dispatch('me')
    },

    me ({ commit }) {
      // console.log("me, response")
      // console.log(response)
      // store.commit('SET_AUTH', (response?.data ?? null))

      return axios.get('user').then((response) => {
        commit('SET_AUTH', response.data)
      }).catch(() => {
        commit('SET_AUTH', null)
      })
    }

  },

}
