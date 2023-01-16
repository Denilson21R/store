<template>
  <tr v-if="product" v-show="!deleted">
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
import axios from "axios";
import * as bulmaToast from "bulma-toast";

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
    requestDeleteProduct(){
      axios.delete('http://localhost:8000/api/product/' + this.product.id, {
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if (response.status === 204){
          this.toast("Produto deletado com sucesso", "is-success")
          this.deleted = true
        }else{
          this.toast("Ocorreu um erro ao obter os clientes", "is-danger")
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