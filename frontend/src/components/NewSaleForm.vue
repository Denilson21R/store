<template>
  <div class="container mx-6">
    <h1 class="title mx-6">Nova venda</h1>
    <form @submit.prevent="submitNewSale" class="mx-6">
      <div class="field" v-if="clients && clients.length > 0">
        <label class="label">Cliente</label>
        <div class="select" v-bind:class="{'is-success':clientValid, 'is-danger':!clientValid}">
          <select v-model="clientId" >
            <option v-bind:value="null">Selecione um cliente</option>
            <option v-for="client in clients" v-bind:key="client.id" v-bind:value="client.id">{{client.name}}</option>
          </select>
        </div>
      </div>
      <div class="field" v-if="products && products.length > 0">
        <label class="label">Produtos</label>
        <div v-for="product in products" v-bind:key="product.id">
          <label class="checkbox">
            <input type="checkbox" v-bind:value="product" v-model="selectedProducts">
            {{ product.name }} - R$ {{product.value}}
          </label>
          <br>
        </div>
      </div>
      <div class="columns">
        <div class="column is-half">
          <div class="field is-half">
            <label class="label">Valor</label>
            <input type="number" min="0.1" step="any" v-bind:class="{'input': true, 'is-success':valueValid, 'is-danger':!valueValid && totalValue != null}" v-model="totalValue">
          </div>
        </div>
        <div class="column is-half" v-if="suggestedValue">
          <div class="field is-half">
            <div class="ml-4 mt-5">
              <label class="label">Valor Sugerido</label>
              R$ {{suggestedValue}}
            </div>
          </div>
        </div>
      </div>
      <div class="field is-grouped">
        <div class="control">
          <button type="submit" class="button is-link">Salvar</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import * as bulmaToast from "bulma-toast";
import router from "@/router";

export default {
  name: "NewSaleForm",
  data(){
    return {
      clientId: null,
      selectedProducts: [],
      totalValue: null,
      products: [],
      clients: [],
      suggestedValue: null
    }
  },
  methods:{
    requestGetAllProducts(){
      axios.get('http://localhost:8000/api/product', {
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if (response.status === 200){
          this.products = response.data.data
        }else{
          this.toast("Ocorreu um erro ao obter os produtos!", "is-danger")
        }
      })
    },
    requestGetAllClients(){
      axios.get('http://localhost:8000/api/client', {
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if (response.status === 200){
          this.clients = response.data.data
        }else{
          this.toast("Ocorreu um erro ao obter os clientes", "is-danger")
        }
      })
    },
    submitNewSale(){
      if(this.clientValid && this.valueValid && this.selectedProducts.length > 0 && this.verifySessionIsValid()){
        this.requestSaveNewSale()
      }else if(!this.verifySessionIsValid()){
        router.push({ path: '/' })
      }else{
        this.toast("Campos obrigatórios não foram preenchidos", "is-danger")
      }
    },
    requestSaveNewSale(){
      axios.post("http://localhost:8000/api/sale", {
        id_client: this.clientId,
        id_user: sessionStorage.getItem("id"),
        products: this.selectedProducts,
        total_value: this.totalValue
      },{
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if(response.status === 201){
          router.push({ path: '/sales' })
          this.toast("Venda salva com sucesso!", "is-success")
        }else{
          this.toast("Ocorreu um erro ao salvar a venda!", "is-danger")
        }
      })
    },
    verifySessionIsValid(){
      return !!sessionStorage.getItem('token');
    },
    toast(message, type){
      bulmaToast.toast({
        message: message,
        type: type,
        dismissible: true
      })
    }
  },
  watch: {
    selectedProducts(newSelected){
      let sumProductsValue = 0
      newSelected.forEach((product)=>{
        sumProductsValue = parseFloat(sumProductsValue) + parseFloat(product.value)
      })
      this.suggestedValue = sumProductsValue
    }
  },
  computed: {
    valueValid(){
      return !!(this.totalValue && this.totalValue > 0)
    },
    clientValid(){
      return !!(this.clientId)
    },
  },
  mounted() {
    if(this.verifySessionIsValid()) {
      this.requestGetAllProducts()
      this.requestGetAllClients()
    }else{
      router.push({ path: '/' })
    }
  }
}
</script>

<style scoped>

</style>