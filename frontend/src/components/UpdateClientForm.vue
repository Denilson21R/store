<template>
  <div class="container mx-6" v-if="client">
    <h1 class="title mx-6">Atualizar Cliente</h1>
    <form @submit.prevent="submitNewClient" class="mx-6">
      <div class="field">
        <label class="label">Nome</label>
        <input type="text" v-bind:class="{'input': true, 'is-success':nameValid, 'is-danger':!nameValid && client.name != null}" v-model="client.name">
      </div>
      <div class="field">
        <label class="label">Endereço</label>
        <input type="text" v-bind:class="{'input': true, 'is-success':nameValid, 'is-danger':!nameValid && client.name != null}" v-model="client.address">
      </div>
      <div class="field">
        <label class="label">Telefone</label>
        <input type="text" v-bind:class="{'input': true, 'is-success':nameValid, 'is-danger':!nameValid && client.name != null}" v-model="client.phone">
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
  name: "UpdateClientForm",
  data(){
    return {
      client: null,
      id: this.$route.params.id
    }
  },
  methods: {
    requestGetClientById(){
      if(this.id){
        axios.get('http://localhost:8000/api/client/'+ this.id , {
          headers: {
            Authorization: 'Bearer ' + sessionStorage.getItem("token")
          }
        }).then((response)=>{
          if (response.status === 200){
            this.client = response.data.data
          }else{
            this.toast("Ocorreu um erro ao obter os dados do cliente!", "is-danger")
          }
        })
      }else {
        this.toast("Cliente inválido!", "is-danger")
        router.push({ path: '/clients' })
      }
    },
    submitNewClient(){
      if(this.nameValid && this.verifySessionIsValid()){
        this.requestUpdateClient()
      }else if(!this.verifySessionIsValid()){
        router.push({ path: '/' })
      }else{
        this.toast("Campos obrigatórios não foram preenchidos corretamente", "is-danger")
      }
    },
    requestUpdateClient(){
      axios.put("http://localhost:8000/api/client/" + this.id, {
        name: this.client.name,
        address: this.client.address,
        phone: this.client.phone
      },{
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if(response.status === 200){
          router.push({ path: '/clients' })
          this.toast("Cliente atualizado com sucesso!", "is-success")
        }else{
          this.toast("Ocorreu um erro ao atualizar o cliente!", "is-danger")
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
    nameValid(){
      return !!(this.client.name != null && this.client.name.length >= 3) //only the name is required, if name is valid then the entire form are valid too
    }
  },
  mounted() {
    if(this.verifySessionIsValid()){
      this.requestGetClientById()
    }else{
      router.push({ path: '/' })
    }
  }
}
</script>

<style scoped>

</style>