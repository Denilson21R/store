<template>
  <MenuHome tab="products"/>
  <button class="button is-info ml-6">Novo produto</button>
  <div class="m-6">
    <ProductsTable/>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import ProductsTable from "@/components/ProductsTable.vue";
export default {
  components: {MenuHome, ProductsTable},
  name: "ProductsView"
}
</script>

<style scoped>

</style>