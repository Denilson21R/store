<template>
  <div class="column is-one-quarter mt-4" v-bind:class="['column', 'is-one-quarter', 'mt-4', hidden]">
    <div class="card">
      <div class="card-content">
        <div class="content">
          <p><span>Cliente: <span class="tag">{{sale.client[0].name}}</span></span></p>
          <p><span>Data: <span class="tag">{{ formatDate(sale.created_at) }}</span></span></p>
          <p><span>Valor: <span class="tag">R$ {{sale.total_value.toFixed(2)}}</span></span></p>
        </div>
      </div>
      <div class="card-footer">
        <button class="button is-link my-2 ml-6" @click="detailSale(this.sale)">Detalhar</button>
        <button class="button is-danger my-2 ml-2 mr-6" @click="deleteSale(this.sale.id)">Deletar</button>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
import axios from "axios";
import * as bulmaToast from "bulma-toast";
import router from "@/router";

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
  methods: {
    detailSale(sale){
      router.push({ path: '/sale/' + sale.id })
    },
    deleteSale(){
      if(this.verifySessionIsValid()){
        this.requestDeleteSale(this.sale.id)
      }else{
        router.push({ path: '/' })
      }
    },
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
    formatDate(){
      return(value)=>{
        return moment(String(value)).format('DD/MM/YYYY hh:mm')
      }
    }
  }
}
</script>

<style scoped>
</style>