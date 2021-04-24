<template>
  <div class="hello">
    <h2>{{ msg }}</h2>
    <p>
      Author: Nguyen Ngoc Nam
    </p>
  </div>
</template>

<script>
export default {
  name: 'HelloWorld',
  props: {
    msg: String
  }
}
</script>
