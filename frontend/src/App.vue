<template>
  <div id="nav">
    <router-link to="/"><i class="fas fa-home"></i> Home (Auth Only)</router-link> |
    <span v-if="!auth">
      <router-link to="/login"><i class="fas fa-sign-in-alt"></i> Login</router-link> |
      <router-link to="/register"><i class="fas fa-registered"></i> Register</router-link> |
    </span>
    <span v-if="auth">
      <a href="javascript:void(0);" @click="handleLogout"><i class="fas fa-sign-out-alt"></i> Logout</a> |
    </span>
    <router-link to="/about"><i class="fas fa-address-card"></i> About</router-link> |
    <router-link to="/products"><i class="fab fa-product-hunt"></i> Products (Auth Only)</router-link>
  </div>
  <router-view/>
</template>

<style>
@import "./assets/styles/index.css";
</style>

<script>
// import { mapState, mapActions, mapMutations, mapGetters } from "vuex"
import { mapState, mapActions, } from "vuex"
// import "./assets/styles/index.less";

export default {
  name: "app",
  computed: {
    ...mapState({
      state_auth: (state) => state.auth.auth
    }),

    auth: {
      get(){
        return this.state_auth.user || JSON.parse(localStorage.getItem("user"))
      }
    }
  },

  methods: {
    ...mapActions({
      signOut: "auth/signOut",
    }),

    async handleLogout() {

      try{
        await this.signOut()

      }catch(e){
        console.log("Logout failed")
        console.error(e)
      }finally{
        this.$router.push({ name: 'Login' })
      }

    },

  },

  // created() {
  //   const isAuthenticated = this.user || JSON.parse(localStorage.getItem("user"))
  //   if (isAuthenticated) {
  //     this.refreshUser()
  //   }
  // },

};
</script>
