<template>
  <div class="tabs is-medium is-toggle is-centered m-4">
    <ul>
      <li v-bind:class="{'is-active': tab === 'home'}"><RouterLink to="/home" >Início</RouterLink></li>
      <li v-bind:class="{'is-active': tab === 'clients'}"><RouterLink to="/clients">Clientes</RouterLink></li>
      <li v-bind:class="{'is-active': tab === 'products'}"><RouterLink to="/products">Produtos</RouterLink></li>
      <li v-bind:class="{'is-active': tab === 'sales'}"><RouterLink to="/sales">Vendas</RouterLink></li>
      <li v-bind:class="{'is-active': tab === 'profile'}"><RouterLink to="/profile">Perfil</RouterLink></li>
    </ul>
    <div class="mr-3">
      {{userName.toUpperCase()}}
    </div>
    <button class="button is-danger mr-6" @click="logout">Sair</button>
  </div>
</template>

<script>
import router from "@/router";

export default {
  name: "MenuHome",
  props: {
    tab: String
  },
  data(){
    return{
      userName: sessionStorage.getItem('name')
    }
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