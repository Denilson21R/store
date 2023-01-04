<template>
  <MenuHome></MenuHome>
  <div class="main m-6">
    <div>Id: {{ id }}</div>
    <div>Login: {{ login }}</div>
    <div>Token: {{ token }}</div>
  </div>
</template>

<script>
import MenuHome from "@/components/Menu.vue";

export default {
  components: {MenuHome},
  data() {
    return {
      id: sessionStorage.getItem('id'),
      login: sessionStorage.getItem('login'),
      token: sessionStorage.getItem('token')
    }
  }
}
</script>

<style scoped>
</style>