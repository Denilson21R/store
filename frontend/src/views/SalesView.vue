<template>
  <MenuHome tab="sales"/>
  <div class="ml-5 container is-narrow">
    <div class="columns is-multiline">
      <template v-for="sale in sales" v-bind:key="sale.id">
        <sale-card :sale="sale" />
      </template>
    </div>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import SaleCard from "@/components/SaleCard.vue";
import axios from "axios";
import * as bulmaToast from "bulma-toast";

export default {
  components: {MenuHome, SaleCard},
  data(){
    return {
      sales: [],
      token: sessionStorage.getItem('token')
    }
  },
  name: "SalesView",
  mounted() {
    axios.get('http://localhost:8000/api/sale/user/' + sessionStorage.getItem('id'), {
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
div{
  /*overflow-y: auto;
  height: 100%;*/
}
</style>