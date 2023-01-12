<template>
  <MenuHome tab="sales"/>

</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import axios from "axios";
import * as bulmaToast from "bulma-toast";
export default {
  name: "DetailSaleView",
  components:{MenuHome},
  data(){
    return {
      sale: null,
      id_sale: this.$route.params.id
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

</style>