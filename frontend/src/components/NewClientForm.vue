<template>
  <div class="container mx-6">
    <h1 class="title mx-6">Novo Cliente</h1>
    <form @submit.prevent="submitNewClient" class="mx-6">
      <div class="field">
        <label class="label">Nome</label>
        <input type="text" v-bind:class="{'input': true, 'is-success':nameValid, 'is-danger':!nameValid && name != null}" v-model="name">
      </div>
      <div class="field">
        <label class="label">Endereço</label>
        <input type="text" v-bind:class="{'input': true, 'is-success':nameValid, 'is-danger':!nameValid && name != null}" v-model="address">
      </div>
      <div class="field">
        <label class="label">Telefone</label>
        <input type="text" v-bind:class="{'input': true, 'is-success':nameValid, 'is-danger':!nameValid && name != null}" v-model="phone">
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
import * as bulmaToast from "bulma-toast";
import axios from "axios";
import router from "@/router";

export default {
  name: "NewClientForm",
  data(){
    return {
      name: null,
      address: null,
      phone: null
    }
  },
  methods: {
    submitNewClient(){
      if(this.nameValid){
        this.requestSaveClient()
      }else{
        this.toast("Campos obrigatórios não foram preenchidos corretamente", "is-danger")
      }
    },
    requestSaveClient(){
      axios.post("http://localhost:8000/api/client", {
        address: this.address,
        name: this.name,
        phone: this.phone,
      },{
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if(response.status === 201){
          router.push({ path: '/clients' })
          this.toast("Cliente salvo com sucesso!", "is-success")
        }else{
          this.toast("Ocorreu um erro ao salvar o cliente!", "is-danger")
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
  },
  computed: {
    nameValid(){
      return !!(this.name && this.name.length >= 3) //only the name is required, if name is valid then the entire form are valid too
    }
  },
}
</script>

<style scoped>

</style>