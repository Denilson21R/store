<template>
  <MenuHome tab="products"/>
  <div class="columns mt-4">
    <div class="column">
      <button class="button is-info ml-6" @click="openFormNewSale">Novo produto</button>
    </div>
    <div class="column">
      <ProductSearchField @search="updateTableSearch"/>
    </div>
  </div>
  <div class="m-6">
    <ProductsTable :search="search"/>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import ProductsTable from "@/components/ProductsTable.vue";
import ProductSearchField from "@/components/ProductSearchField.vue";
import router from "@/router";

export default {
  components: {ProductSearchField, MenuHome, ProductsTable},
  name: "ProductsView",
  data(){
    return {
      search: null
    }
  },
  methods:{
    openFormNewSale(){
      router.push({ path: '/products/new' })
    },
    verifySessionIsValid(){
      return !!sessionStorage.getItem('token')
    },
    updateTableSearch(nameSearch){
      this.search = nameSearch
    }
  },
  mounted() {
    if(!this.verifySessionIsValid()){
      router.push({ path: '/' })
    }
  }
}
</script>

<style scoped>
</style>