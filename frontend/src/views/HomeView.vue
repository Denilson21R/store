<template>
  <div class="main m-6">
    <div>Id: {{ id }}</div>
    <div>Login: {{ login }}</div>
    <div>Token: {{ token }}</div>
    <button class="button is-link" @click="logout">Sair</button>
  </div>
</template>

<script>
import router from "@/router";

export default {
  data() {
    return {
      id: sessionStorage.getItem('id'),
      login: sessionStorage.getItem('login'),
      token: sessionStorage.getItem('token')
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