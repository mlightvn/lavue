<template>
  <div class="about">
    <h1>Products</h1>
    <div class="container">
      <div class="row">
        <div
          class="col m3"
          v-for="(item, index) in items"
          :key="index"
        >
          <ProductDetail
            :item="item"
          />

        </div>

      </div>
    </div>

  </div>
</template>

<script>
import ProductDetail from "./components/list/ProductDetail.vue"


export default {
  name: 'Products',
  components: {
    ProductDetail,
  },

  data() {
    return {
      items: [
        {id:1, title: "House 1", description: "House detail 1 ...", price: 100000000},
        {id:2, title: "House 2", description: "House detail 2 ...", price: 200000000},
        {id:3, title: "House 3", description: "House detail 3 ...", price: 300000000},
        {id:4, title: "House 4", description: "House detail 4 ...", price: 400000000},
      ],
    }
  }
}
</script>
