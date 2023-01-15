<template>
  <tr v-if="product">
    <td>{{product.name}}</td>
    <td>{{product.value}}</td>
    <td>{{ product.description }}</td>
    <td>
      <button class="button is-link">Atualizar</button>
      <button class="button is-danger mx-2">Deletar</button>
    </td>
  </tr>
</template>

<script>
export default {
  name: "ProductDetailedCell",
  props:{
    product: Object
  }
}
</script>

<style scoped>

</style>