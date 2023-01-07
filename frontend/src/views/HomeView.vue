<template>
  <MenuHome tab="home"/>
  <div class="main m-6">
    <div>Id: {{ id }}</div>
    <div>Nome: {{ name }}</div>
    <div>Login: {{ login }}</div>
    <div>Token: {{ token }}</div>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";

export default {
  components: {MenuHome},
  data() {
    return {
      id: sessionStorage.getItem('id'),
      login: sessionStorage.getItem('login'),
      name: sessionStorage.getItem('name'),
      token: sessionStorage.getItem('token')
    }
  }
}
</script>

<style scoped>
</style>