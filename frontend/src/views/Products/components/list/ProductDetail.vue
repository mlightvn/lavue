<template>
  <div class="card grey lighten-4">
    <div class="card-image">
      <img :src="require('@/assets/logo/logo_256.png')">
    </div>
    <div class="card-content">
      <span class="card-title">{{ item.title }}</span>
      <p>{{item.description}}</p>
    </div>
    <div class="card-stacked green-text lighten-3">
      <span>{{ currency(item.price) }}</span>
    </div>
    <div class="card-action green-text"
    >
      <a :href="'/products/' + item.id"><i class="fas fa-info-circle"></i> Detail</a>
    </div>
  </div>
</template>

<script>
export default {
  components: {
  },

  props: {
    item: Object,
  },

  methods:{
    currency(value) {
      if(value === undefined || value === null || value === "")value = 0
      return Number(value).toLocaleString() + " VND"
    }
  }
}
</script>
