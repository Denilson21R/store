<template>
  <tr v-if="product">
    <td>{{product.name}}</td>
    <td>{{product.value}}</td>
    <td class="description">{{ product.description }}</td>
    <td class="is-vcentered has-text-centered">
      <button class="button is-link">Atualizar</button>
      <button class="button is-danger mx-2" @click="deleteProduct">Deletar</button>
    </td>
  </tr>
</template>

<script>
export default {
  name: "ProductDetailedCell",
  props:{
    product: Object
  },
  methods: {
    deleteProduct(){
      alert(this.product.id)
    }
  }
}
</script>

<style scoped>
.description{
  width: 60%
}
</style>