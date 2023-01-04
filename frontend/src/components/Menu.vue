<template>
  <div class="tabs is-medium is-toggle is-centered m-6">
    <ul>
      <li class="is-active"><a>Início</a></li>
      <li><a>Clientes</a></li>
      <li><a>Produtos</a></li>
      <li><a>Vendas</a></li>
    </ul>
    <button class="button is-danger" @click="logout">Sair</button>
  </div>
</template>

<script>
import router from "@/router";

export default {
  name: "MenuHome",
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