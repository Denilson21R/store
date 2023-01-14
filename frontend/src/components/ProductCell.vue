<template>
  <tr v-if="product">
    <td class="has-text-centered">{{ product.name }}</td>
    <td class="has-text-centered">{{ product.value }}</td>
  </tr>
</template>

<script>
export default {
  name: "ProductCell",
  props:{
    product: Object
  }
}
</script>

<style scoped>

</style>