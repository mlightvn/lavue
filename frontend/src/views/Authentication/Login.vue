<template>
  <div class="about">
    <h1>LOGIN</h1>
    <div class="container">
      <div class="row">
        <form class="col s12 m6 offset-m3">
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">email</i>
              <input id="email" type="email" class="validate"
                v-model="user.email"
              >
              <label for="email">Email</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">password</i>
              <input id="password" type="password" class="validate"
                v-model="user.password"
              >
              <label for="password">Password</label>
            </div>
          </div>

          <div class="row">
            <div class="col s6">
              <button
                type="button"
                class="waves-effect waves-light btn-large primary"
                @click="handleLogin"
              >Login</button>
            </div>

            <div class="col s6">
              Don't have account:
              <router-link to="/register">Register now</router-link>
            </div>
          </div>

          <div class="row"
            v-if="user.authenticated !== null"
          >
            <div class="input-field col s12">
              <div
                v-if="user.authenticated === 0"
                class="green accent-3 white-text"
              >
                Login successfully.
              </div>
              <div
                v-if="user.authenticated === 1"
                class="red white-text"
              >
                Login failed.
              </div>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</template>

<script>
// https://fonts.google.com/icons?selected=Material+Icons&icon.query=email

// import { mapState, mapActions, mapGetters, mapMutations } from "vuex";
import { mapState, mapActions } from "vuex";

// import {login} from '@/services/Authentication'
// import {signIn} from '@/store/auth'

export default {
  name: 'Login',
  components: {
  },

  data() {
    return {
      user: {
        email: "ngocnam.sk@gmail.com",
        password: "12345678",
        authenticated: null, //0: success, 1: failed, null: not logged-in yet
      }
    }
  },

  computed: {
    ...mapState({
      auth: (state) => state.auth,
    }),
    // ...mapGetters({
    //   // user: "user",
    // }),
  },

  methods: {
    ...mapActions({
      signIn: "auth/signIn",
    }),
    // ...mapMutations({
    // }),

    async handleLogin() {

      try{
        // await this.$store.commit("auth/signIn", this.user)
        await this.signIn(this.user)
console.log("this.auth")
console.log(this.auth)
        if(this.auth.user){
          this.$router.replace({ name: 'home' })
          // this.$router.push('home')

          this.user.authenticated = 0

        }else{
          this.user.authenticated = 1
        }
      }catch(e){
        console.log("Login failed")
        console.error(e)
        this.user.authenticated = 1
      }

    }
  }
}
</script>