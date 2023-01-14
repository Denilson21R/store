<template>
  <MenuHome tab="sales"/>
  <div class="main m-6">
    <div class="box has-text-centered has-background-grey-lighter" v-if="sale">
      <span class="has-text-weight-bold">Valor:</span> R${{sale.total_value.toFixed(2)}} <br>
      <span class="has-text-weight-bold">Data:</span> {{formatDate(sale.created_at)}}
    </div>
    <div class="box has-text-centered has-background-danger-light" v-if="sale">
      <span class="has-text-weight-bold">Nome do Cliente:</span> {{sale.client[0].name}} <br>
      <span class="has-text-weight-bold">Endereço do Cliente:</span> {{sale.client[0].address}} <br>
      <span class="has-text-weight-bold">Telefone do Cliente:</span> {{sale.client[0].phone}}
    </div>
    <div class="box is-align-items-center has-background-info-light" v-if="sale && sale.products.length > 0">
      <div class="subtitle has-text-centered">Produtos</div>
      <table class="table is-bordered is-hoverable">
        <thead>
          <th class="has-text-centered">Nome</th>
          <th class="has-text-centered">Valor (R$)</th>
        </thead>
        <tbody>
          <ProductCell v-for="product in sale.products" :product="product" v-bind:key="product.id"/>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import ProductCell from "@/components/ProductCell.vue";
import axios from "axios";
import * as bulmaToast from "bulma-toast";
import moment from "moment/moment";

export default {
  name: "DetailSaleView",
  components:{MenuHome, ProductCell},
  data(){
    return {
      sale: null,
      id_sale: this.$route.params.id
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
    requestGetSaleDetails(){
      axios.get('http://localhost:8000/api/sale/'+this.id_sale, {
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem("token")
        }
      }).then((response)=>{
        if (response.status === 200){
          this.sale = response.data.data
          console.log(this.sale.products)
        }else{
          bulmaToast.toast({
            message: "Ocorreu um erro ao obter os dados da venda!",
            type: 'is-danger',
            dismissible: true
          })
        }
      })
    }
  },
  mounted() {
    this.requestGetSaleDetails()
  }
}
</script>

<style scoped>
.box{
  margin-inline: auto;
}
.table {
  margin-left: auto;
  margin-right: auto;
}
</style>