<template>
  <MenuHome tab="sales"/>
  <button class="button is-info ml-6" @click="openFormNewSale">Nova Venda</button>
  <div class="ml-5 mx-6 container is-narrow">
    <div class="columns is-multiline">
      <template v-if="sales.length > 0">
        <template v-for="sale in sales" v-bind:key="sale.id">
          <sale-card :sale="sale" @deleteCard="deleteCardInList"/>
        </template>
      </template>
      <template v-else>
        <div class="notification is-danger m-6">
          Nenhuma venda foi encontrada
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import SaleCard from "@/components/SaleCard.vue";
import axios from "axios";
import * as bulmaToast from "bulma-toast";
import router from "@/router";

export default {
  components: {MenuHome, SaleCard},
  data(){
    return {
      sales: [],
      token: sessionStorage.getItem('token')
    }
  },
  name: "SalesView",
  methods:{
    deleteCardInList(id){
      this.sales.forEach((sale)=>{
        if(sale.id === id){
          this.deleteSaleInArrayByIndex(sale)
        }
      })
    },
    deleteSaleInArrayByIndex(sale){
      let index = this.sales.indexOf(sale)
      if (index > -1) {
        this.sales.splice(index, 1);
      }
    },
    openFormNewSale(){
      router.push({ path: '/sales/new' })
    }
  },
  mounted() {
    axios.get('http://localhost:8000/api/sale', {
      headers: {
        Authorization: 'Bearer ' + this.token
      }
    }).then((response)=>{
      if (response.status === 200){
        this.sales = response.data.data
      }else{
        bulmaToast.toast({
          message: "Ocorreu um erro ao obter as vendas!",
          type: 'is-danger',
          dismissible: true
        })
      }
    })
  }
}
</script>

<style scoped>

</style>