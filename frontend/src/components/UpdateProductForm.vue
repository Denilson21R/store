<template>
  <div class="container mx-6" v-if="product">
    <h1 class="title mx-6">Atualizar produto</h1>
    <form @submit.prevent="updateProduct" class="mx-6">
      <div class="field">
        <label class="label">Nome</label>
        <input type="text" v-bind:class="{'input': true, 'is-success':nameValid, 'is-danger':!nameValid}" v-model="product.name">
      </div>
      <div class="field">
        <label class="label">Valor</label>
        <input type="number" min="0.1" step="any" v-bind:class="{'input': true, 'is-success':valueValid, 'is-danger':!valueValid}" v-model="product.value">
      </div>
      <div class="field">
        <label class="label">Descrição</label>
        <textarea type="text" v-bind:class="{'textarea': true, 'is-success':descriptionValid, 'is-danger':!descriptionValid}" v-model="product.description"></textarea>
      </div>
      <div class="field is-grouped">
        <div class="control">
          <button type="submit" class="button is-link">Atualizar</button>
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
  name: "UpdateProductForm",
  data(){
    return {
      product: null,
      id: this.$route.params.id
    }
  },
  methods:{
    updateProduct(){
      if(this.valueValid && this.nameValid && this.descriptionValid && this.verifySessionIsValid()){
        this.requestUpdateProduct()
      }else if(!this.verifySessionIsValid()){
        router.push({ path: '/' })
      }else{
        this.toast("Campos obrigatórios não foram preenchidos corretamente", "is-danger")
      }
    },
    requestUpdateProduct(){
      axios.put("http://localhost:8000/api/product/" + this.id, {
        name: this.product.name,
        description: this.product.description,
        value: this.product.value
      },{
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if(response.status === 200){
          router.push({ path: '/products' })
          this.toast("Produto atualizado com sucesso!", "is-success")
        }else{
          this.toast("Ocorreu um erro ao atualizar o produto!", "is-danger")
        }
      })
    },
    requestGetProductById(){
      if(this.id){
        axios.get('http://localhost:8000/api/product/'+ this.id , {
          headers: {
            Authorization: 'Bearer ' + sessionStorage.getItem("token")
          }
        }).then((response)=>{
          if (response.status === 200){
            this.product = response.data.data
          }else{
            this.toast("Ocorreu um erro ao obter os dados do produto!", "is-danger")
          }
        })
      }else {
        this.toast("Produto inválido!", "is-danger")
        router.push({ path: '/products' })
      }
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
      return !!(this.product.value && this.product.value > 0)
    },
    nameValid(){
      return !!(this.product.name && this.product.name.length >= 3)
    },
    descriptionValid(){
      return !!(this.product.description != null && this.product.description.length >= 6)
    }
  },
  mounted() {
    if(this.verifySessionIsValid()){
      this.requestGetProductById()
    }else{
      router.push({ path: '/' })
    }
  }
}
</script>

<style scoped>

</style>