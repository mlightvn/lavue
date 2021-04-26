<template>
  <div class="about">
    <h1>REGISTER</h1>
    <div class="container">
      <div class="row">
        <form class="col s12 m6 offset-m3">
          <div class="row">
            <div class="input-field col s12">
              <span class="material-icons prefix">person_add</span>
              <input id="name" type="text" class="validate">
              <label for="name">Name</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">email</i>
              <input id="email" type="email" class="validate">
              <label for="email">Email</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">password</i>
              <input id="password" type="password" class="validate">
              <label for="password">Password</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">password</i>
              <input id="confirmed_password" type="password" class="validate">
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

export default {
  name: 'Login',
  components: {
  },

  methods: {
    async handleRegister() {
      console.log("handleRegister")
    }
  }
}
</script>