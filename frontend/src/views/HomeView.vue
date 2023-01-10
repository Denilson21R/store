<template>
  <MenuHome tab="home"/>
  <div class="main m-6">
    <div class="columns is-multiline">
      <HomeStatsCard stat="Soma total de valor das vendas" :stat-value="this.totalValueSales" tag="is-danger"/>
      <HomeStatsCard stat="Quantidade total de vendas" :stat-value="qtySales" tag="is-success"/>
      <HomeStatsCard stat="Quantidade total de produtos" :stat-value="qtyProducts" tag="is-primary"/>
      <HomeStatsCard stat="Quantidade total de clientes" :stat-value="qtyClients" tag="is-warning"/>
    </div>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import HomeStatsCard from "@/components/HomeStatsCard.vue";
import axios from "axios";
import * as bulmaToast from "bulma-toast";

export default {
  components: {MenuHome, HomeStatsCard},
  data() {
    return {
      id: sessionStorage.getItem('id'),
      login: sessionStorage.getItem('login'),
      name: sessionStorage.getItem('name'),
      token: sessionStorage.getItem('token'),
      totalValueSales: null,
      qtySales: null,
      qtyProducts: null,
      qtyClients: null,
    }
  },
  methods:{
    toast(message, type){
      bulmaToast.toast({
        message: message,
        type: type,
        dismissible: true
      })
    },
    requestGetSaleStats(){
      axios.get('http://localhost:8000/api/sale-stats', {
        headers: {
          Authorization: 'Bearer ' + this.token
        }
      }).then((response)=>{
        if (response.status === 200){
          this.totalValueSales = "R$ "+response.data.total_amount.toFixed(2)
          this.qtySales = response.data.quantity.toString()
        }else{
          this.toast("Ocorreu um erro ao obter os status das vendas!", "is-danger")
        }
      })
    },
    requestGetClientsStats(){
      axios.get('http://localhost:8000/api/client-qty', {
        headers: {
          Authorization: 'Bearer ' + this.token
        }
      }).then((response)=>{
        if (response.status === 200){
          this.qtyClients = response.data.quantity.toString()
        }else{
          this.toast("Ocorreu um erro ao obter a quantidade de clientes!", "is-danger")
        }
      })
    },
    requestGetProductsStats(){
      axios.get('http://localhost:8000/api/product-qty', {
        headers: {
          Authorization: 'Bearer ' + this.token
        }
      }).then((response)=>{
        if (response.status === 200){
          this.qtyProducts = response.data.quantity.toString()
        }else{
          this.toast("Ocorreu um erro ao obter a quantidade de clientes!", "is-danger")
        }
      })
    }
  },
  mounted() {
    this.requestGetSaleStats()
    this.requestGetClientsStats()
    this.requestGetProductsStats()
  }
}
</script>

<style scoped>
</style>