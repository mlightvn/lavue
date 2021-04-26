<template>
  <div class="about">
    <h1>REGISTER</h1>
    <div class="container">
      <div class="row">
        <form
          class="col s12 m6 offset-m3"
          action="#"
          @submit.prevent="submit"
        >
          <div class="row">
            <div class="input-field col s12">
              <span class="material-icons prefix">person_add</span>
              <input id="name" type="text" class="validate" v-model="user.name">
              <label for="name">Name</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">email</i>
              <input id="email" type="email" class="validate" v-model="user.email">
              <label for="email">Email</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">password</i>
              <input id="password" type="password" class="validate" v-model="user.password">
              <label for="password">Password</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">password</i>
              <input id="confirmed_password" type="password" class="validate" v-model="user.confirmed_password">
              <label for="confirmed_password">Confirmed Password</label>
            </div>
          </div>

          <div class="row">
            <div class="col s6">
              <button
                type="button"
                class="waves-effect waves-light btn-large primary"
                @click="handleRegister"
              >Register</button>
            </div>

            <div class="col s6">
              Have account:
              <router-link to="/login">Login</router-link>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</template>

<script>
// https://fonts.google.com/icons?selected=Material+Icons&icon.query=email
import { mapState, mapActions } from "vuex";

export default {
  name: 'Login',

  data() {
    return {
      user: {
        name: "Nguyen Ngoc Nam",
        email: "test2@lavue.nam",
        password: "12345678",
        confirmed_password: "12345678",
        authenticated: null, //0: success, 1: failed, null: not logged-in yet
      },
    }
  },

  components: {
  },

  computed: {
    ...mapState({
      auth: (state) => state.auth.auth,
    }),

  },

  methods: {
    ...mapActions({
      register: "auth/register",
    }),

    async handleRegister() {
      try{
        await this.register(this.user)
        if(this.auth.user){
          if(this.$route.query.redirect){
            this.$router.push(this.$route.query.redirect)
          }else{
            this.$router.replace({ name: 'Home' })
          }

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