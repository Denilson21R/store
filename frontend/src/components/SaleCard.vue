<template>
  <div class="card column is-one-quarter mt-4">
    <div class="card-content">
      <div class="content">
        <p><span>Cliente: <span class="tag">{{this.sale.client[0].name}}</span></span></p>
        <p><span>Data: <span class="tag">{{ formatDate(this.sale.created_at) }}</span></span></p>
        <p><span>Valor: <span class="tag">R$ {{this.sale.total_value.toFixed(2)}}</span></span></p>
      </div>
    </div>
    <footer class="card-footer">
      <button class="button is-link m-2">Detalhar</button>
      <button class="button is-danger m-2">Deletar</button>
    </footer>
  </div>
</template>

<script>
import moment from 'moment';
export default {
  name: "SaleCard",
  props: {
    sale: Object
  },
  computed: {
    formatDate(){
      return(value)=>{
        return moment(String(value)).format('MM/DD/YYYY hh:mm')
      }
    }
  }
}
</script>

<style scoped>
</style>