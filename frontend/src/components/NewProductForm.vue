<template>
  <div class="container mx-6">
    <h1 class="title mx-6">Novo produto</h1>
    <form @submit.prevent="submitNewProduct" class="mx-6">
      <div class="field">
        <label class="label">Nome</label>
        <input type="text" v-bind:class="{'input': true, 'is-success':nameValid, 'is-danger':!nameValid && name != null}" v-model="name">
      </div>
      <div class="field">
        <label class="label">Valor</label>
        <input type="number" min="0.1" step="any" v-bind:class="{'input': true, 'is-success':valueValid, 'is-danger':!valueValid && totalValue != null}" v-model="totalValue">
      </div>
      <div class="field">
        <label class="label">Descrição</label>
        <textarea type="text" v-bind:class="{'textarea': true, 'is-success':descriptionValid, 'is-danger':!descriptionValid && description != null}" v-model="description"></textarea>
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
import router from "@/router";
import * as bulmaToast from "bulma-toast";

export default {
  name: "NewProductForm",
  data(){
    return {
      name: null,
      totalValue: null,
      description: null
    }
  },
  methods:{
    submitNewProduct(){
      if(this.valueValid && this.nameValid && this.descriptionValid && this.verifySessionIsValid()){
        this.requestSaveNewProduct()
      }else if(!this.verifySessionIsValid()){
        router.push({ path: '/' })
      }else{
        this.toast("Campos obrigatórios não foram preenchidos corretamente", "is-danger")
      }
    },
    requestSaveNewProduct(){
      axios.post("http://localhost:8000/api/product", {
        value: this.totalValue,
        name: this.name,
        description: this.description,
      },{
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if(response.status === 201){
          router.push({ path: '/products' })
          this.toast("Produto salvo com sucesso!", "is-success")
        }else{
          this.toast("Ocorreu um erro ao salvar o produto!", "is-danger")
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
  computed: {
    valueValid(){
      return !!(this.totalValue && this.totalValue > 0)
    },
    nameValid(){
      return !!(this.name && this.name.length >= 3)
    },
    descriptionValid(){
      return !!(this.description != null && this.description.length >= 6)
    }
  },
}
</script>

<style scoped>

</style>