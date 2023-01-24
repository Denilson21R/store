<template>
  <tr v-if="product" v-show="!deleted">
    <td>{{product.name}}</td>
    <td>{{product.value}}</td>
    <td class="description">{{ product.description }}</td>
    <td class="is-vcentered has-text-centered">
      <button class="button is-link" @click="updateProduct">Atualizar</button>
      <button class="button is-danger mx-2" @click="deleteProduct">Deletar</button>
    </td>
  </tr>
</template>

<script>
import axios from "axios";
import * as bulmaToast from "bulma-toast";
import router from "@/router";

export default {
  name: "ProductDetailedCell",
  props:{
    product: Object
  },
  data(){
    return {
      deleted: false
    }
  },
  methods: {
    deleteProduct(){
      this.requestDeleteProduct()
    },
    updateProduct(){
      router.push({ path: '/product/' + this.product.id })
    },
    requestDeleteProduct(){
      axios.delete('http://localhost:8000/api/product/' + this.product.id, {
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if (response.status === 204){
          this.toast("Produto deletado com sucesso", "is-success")
          this.deleted = true
        }else if(response.status === 200){
          this.toast("Produto não pode ser deletado, pois está ligado à uma venda", "is-danger")
        }else{
          this.toast("Ocorreu um erro ao deletar o produto", "is-danger")
        }
      })
    },
    toast(message, type){
      bulmaToast.toast({
        message: message,
        type: type,
        dismissible: true
      })
    }
  }
}
</script>

<style scoped>
.description{
  width: 60%
}
</style>