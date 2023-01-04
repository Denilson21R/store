<template>
  <div class="tabs is-medium is-toggle is-centered m-5">
    <ul>
      <li v-bind:class="{'is-active': tab === 'home'}"><RouterLink to="/home" >Início</RouterLink></li>
      <li v-bind:class="{'is-active': tab === 'clients'}"><RouterLink to="/clients">Clientes</RouterLink></li>
      <li v-bind:class="{'is-active': tab === 'products'}"><RouterLink to="/products">Produtos</RouterLink></li>
      <li v-bind:class="{'is-active': tab === 'sales'}"><RouterLink to="/sales">Vendas</RouterLink></li>
    </ul>
    <button class="button is-danger" @click="logout">Sair</button>
  </div>
</template>

<script>
import router from "@/router";

export default {
  name: "MenuHome",
  props: {
    tab: String
  },
  methods: {
    logout(){
      sessionStorage.clear()
      router.push({path: '/'})
    }
  }
}
</script>

<style scoped>

</style>