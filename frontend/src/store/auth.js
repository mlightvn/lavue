import axios from 'axios'


// ref: https://github.com/vuejs/vuex/blob/4.0/examples/classic/shopping-cart/store/modules/products.js


export default {
  namespaced: true,

  state: () => ({
    auth: {
      user: localStorage.getItem('auth') ?? null,
      token: localStorage.getItem('token') ?? null,
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
    SET_AUTH (state, {user, token}) {
      state.auth.user = user
      state.auth.token = token
      if(user){
        localStorage.setItem('user', JSON.stringify(user))
      }else{
        localStorage.removeItem('user')
      }
      if(token){
        localStorage.setItem('token', JSON.stringify(token))
      }else{
        localStorage.removeItem('token')
      }
    },

    SET_TOKEN(state, value){
      state.auth.token = value
      if(value){
        localStorage.setItem('token', JSON.stringify(value))
      }else{
        localStorage.removeItem('token')
      }
    },

    SET_USER(state, value){
      state.auth.user = value
      if(value){
        localStorage.setItem('user', JSON.stringify(value))
      }else{
        localStorage.removeItem('user')
      }
    },

  },

  actions: {
    async signIn ({ dispatch, commit }, credentials) {
      await axios.get('../sanctum/csrf-cookie')
      await axios.post("login", credentials)
        .then((response)=>{
          commit('SET_TOKEN', response.data.data.token)
        })
        .catch((error) => {
          console.log("error: login failed.")
          console.error(error)
          commit('SET_TOKEN', null)
        })

      await dispatch('me')
    },

    async signOut ({ dispatch }) {
      await axios.post('logout', null)

      await dispatch('me')
    },

    async me ({ commit, state }) {
      const config = {
        headers: {
          "Content-type": "application/json",
          "Authorization": `Bearer ${state.auth.token}`,
         },
      };

      return await axios.get('user', config)
      .then((response) => {
        commit('SET_USER', {user: response.data})
      }).catch(() => {
        commit('SET_USER', null)
      })
    }

    // async me ({ commit }) {
    //   let token = "28|4QwlF0yH9KU35Py7lZfVN6VqF9b2PEqAhUz1tI9s"
    //   const config = {
    //     headers: {
    //       "Content-type": "application/json",
    //       "Authorization": `Bearer ${token}`,
    //      },
    //   };

    //   return await axios.get('user', config)
    //   .then((response) => {
    //     commit('SET_USER', response.data)
    //   }).catch(() => {
    //     commit('SET_USER', null)
    //   })
    // }

  },

}
