<template>
  <MenuHome tab="clients"/>
  <button class="button is-info ml-6">Novo cliente</button>
  <div class="m-6">
    clients
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
export default {
  components: {MenuHome},
  name: "ClientsView"
}
</script>

<style scoped>

</style>