<template>
  <div class="column is-one-quarter mt-4" v-bind:class="['column', 'is-one-quarter', 'mt-4', hidden]">
    <div class="card">
      <div class="card-content">
        <div class="content">
          <p><span>Cliente: <span class="tag">{{this.sale.client[0].name}}</span></span></p>
          <p><span>Data: <span class="tag">{{ formatDate(this.sale.created_at) }}</span></span></p>
          <p><span>Valor: <span class="tag">R$ {{this.sale.total_value.toFixed(2)}}</span></span></p>
        </div>
      </div>
      <div class="card-footer">
          <button class="button is-link m-2">Detalhar</button>
          <button class="button is-danger m-2" @click="requestDeleteSale(this.sale.id)">Deletar</button>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
import axios from "axios";
import * as bulmaToast from "bulma-toast";
export default {
  name: "SaleCard",
  props: {
    sale: Object
  },
  data() {
    return {
      hidden: ""
    }
  },
  computed: {
    formatDate(){
      return(value)=>{
        return moment(String(value)).format('DD/MM/YYYY hh:mm')
      }
    }
  },
  methods: {
    requestDeleteSale(id){
      axios.delete('http://localhost:8000/api/sale/' + id, {
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if (response.status === 204){
          this.deleteCard(id)
          this.toast("Venda deletada com sucesso!", "is-success")
        }else{
          this.toast("Ocorreu um erro ao deletar a venda!", "is-danger")
        }
      })
    },
    deleteCard(id){
      this.hidden = "is-hidden"
      this.$emit('deleteCard', id)
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
</style>