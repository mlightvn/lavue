<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo/logo_256.png">
    <HelloWorld msg="Welcome to Laravel VueJS demo project"/>
  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from '@/components/HelloWorld.vue'

export default {
  name: 'Home',
  components: {
    HelloWorld
  }
}
</script>
