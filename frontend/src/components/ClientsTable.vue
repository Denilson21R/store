<template>

  <div v-if="clients && clients.length > 0">
    <table class="table is-bordered">
      <thead class="has-background-link-light">
      <th class="has-text-centered">Nome</th>
      <th class="has-text-centered">Endereço</th>
      <th class="has-text-centered">Telefone</th>
      <th class="has-text-centered">Ações</th>
      </thead>
      <tbody>
      <ClientCell v-for="client in clients" v-bind:key="client.id" :client="client"/>
      </tbody>
    </table>
  </div>

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
import ClientCell from "@/components/ClientCell.vue";
import router from "@/router";

export default {
  name: "ClientsTable",
  components: {ClientCell},
  props:{
    search: String
  },
  data() {
    return {
      clients: null,
      token: sessionStorage.getItem('token')
    }
  },
  methods:{
    requestGetAllClients(){
      axios.get('http://localhost:8000/api/client', {
        headers: {
          Authorization: 'Bearer ' + this.token
        }
      }).then((response)=>{
        if (response.status === 200){
          this.clients = response.data.data
        }else{
          bulmaToast.toast({
            message: "Ocorreu um erro ao obter os clientes!",
            type: 'is-danger',
            dismissible: true
          })
        }
      })
    },
    requestGetClientsWithNameFilter(name){
      axios.get('http://localhost:8000/api/client/search/'+name, {
        headers: {
          Authorization: 'Bearer ' + this.token
        }
      }).then((response)=>{
        if (response.status === 200){
          this.clients = response.data.data
        }else{
          bulmaToast.toast({
            message: "Ocorreu um erro ao filtrar os clientes!",
            type: 'is-danger',
            dismissible: true
          })
        }
      })
    },
    verifySessionIsValid(){
      return !!sessionStorage.getItem('token');
    }
  },
  watch:{
    search(newSearch){
      if(newSearch !== ""){
        this.requestGetClientsWithNameFilter(newSearch)
      }else{
        this.requestGetAllClients()
      }
    }
  },
  mounted() {
    if(this.verifySessionIsValid()){
      this.requestGetAllClients()
    }else{
      router.push({ path: '/' })
    }
  }
}
</script>

<style scoped>

</style>