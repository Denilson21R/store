<template>
  <table class="table is-bordered is-hoverable" v-if="products && products.length > 0"> <!--TODO: melhorar estilo da tabela-->
    <thead>
    <th class="has-text-centered">Nome</th>
    <th class="has-text-centered">Valor (R$)</th>
    <th class="has-text-centered">Descrição</th> <!--TODO: maximo 100 caracteres, substituir excesso por '...'-->
    <th class="has-text-centered">Ações</th> <!--TODO: implementar acoes-->
    </thead>
    <tbody>
      <productDetailedCell v-for="product in products" v-bind:key="product.id" :product="product"/>
    </tbody>
  </table>
  <template v-else>
    <div class="ml-5 mx-6 container is-narrow">
      <div class="columns is-multiline">
        <div class="notification is-danger">
          Nenhum produto foi encontrado
        </div>
      </div>
    </div>
  </template>
</template>

<script>
import axios from "axios";
import * as bulmaToast from "bulma-toast";
import productDetailedCell from "@/components/ProductDetailedCell.vue";

export default {
  name: "ProductsTable",
  components: {productDetailedCell},
  data() {
    return {
      products: null,
      token: sessionStorage.getItem('token')
    }
  },
  methods:{
    requestGetAllProducts(){
      axios.get('http://localhost:8000/api/product', {
        headers: {
          Authorization: 'Bearer ' + this.token
        }
      }).then((response)=>{
        if (response.status === 200){
          this.products = response.data.data
        }else{
          bulmaToast.toast({
            message: "Ocorreu um erro ao obter os produtos!",
            type: 'is-danger',
            dismissible: true
          })
        }
      })
    }
  },
  mounted() {
    this.requestGetAllProducts()
  }
}
</script>

<style scoped>

</style>