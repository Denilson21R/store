<template>
  <tr v-if="client" v-show="!deleted">
    <td class="is-vcentered">{{client.name}}</td>
    <td class="address is-vcentered">{{client.address}}</td>
    <td class="is-vcentered">{{ client.phone }}</td>
    <td class="is-vcentered has-text-centered">
      <button class="button is-link" @click="updateClient">Atualizar</button>
      <button class="button is-danger mx-2" @click="deleteClient">Deletar</button>
    </td>
  </tr>
</template>

<script>
import router from "@/router";
import axios from "axios";
import * as bulmaToast from "bulma-toast";

export default {
  name: "ClientCell",
  props:{
    client: Object
  },
  data(){
    return {
      deleted: false
    }
  },
  methods: {
    deleteClient(){
      if(this.verifySessionIsValid()){
        this.requestDeleteClient()
      }else{
        router.push({ path: '/' })
      }
    },
    updateClient(){
      router.push({ path: '/client/' + this.client.id })
    },
    requestDeleteClient(){
      axios.delete('http://localhost:8000/api/client/' + this.client.id, {
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if (response.status === 204){
          this.toast("Cliente deletado com sucesso", "is-success")
          this.deleted = true
        }else if(response.status === 200){
          this.toast("Cliente não pode ser deletado, pois está ligado à uma venda", "is-danger")
        }else{
          this.toast("Ocorreu um erro ao deletar o cliente", "is-danger")
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
  }
}
</script>

<style scoped>
.address{
  width: 48%
}
</style>