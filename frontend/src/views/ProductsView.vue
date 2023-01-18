<template>
  <MenuHome tab="products"/>
  <button class="button is-info ml-6" @click="openFormNewSale">Novo produto</button>
  <div class="m-6">
    <ProductsTable/>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import ProductsTable from "@/components/ProductsTable.vue";
import router from "@/router";

export default {
  components: {MenuHome, ProductsTable},
  name: "ProductsView",
  methods:{
    openFormNewSale(){
      router.push({ path: '/products/new' })
    }
  }
}
</script>

<style scoped>

</style>